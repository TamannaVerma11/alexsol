<?php

namespace App\Http\Controllers\API;

use App\HTTP\Requests\Register\ConsultantRegisterRequest;
use App\HTTP\Requests\Register\CompanyRegisterRequest;
use App\HTTP\Requests\Register\UserRegisterRequest;
use App\HTTP\Requests\ProfileRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Login\RememberMeExpiration;
use App\HTTP\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\JsonResponse;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    use RememberMeExpiration;

    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::find($id);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function userRegister(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password'),
            'company_id' => (!empty($request->input('company_id'))),
            'approve_per' => $request->input('approve_per'),
            'user_type' => 'user',
            'approve_per' => 0,
        ]);

        if(!empty($request->input('company_id'))){
            $company = Company::find($request->input('company_id'));
            if($company){
                $company->size = User::where('company_id', $company->id)->get()->count();
                $company->save();
            }
        }
        $user->updateTracker('Sign up');

        // Handle image upload
        if ($request->hasFile('image') && !empty($request->file('image'))) {
            $image = $this->imageUpload($request->file('image'), 'images/user_logo');
            //Remove the old image (New image uploaded)
            if (isset($user->profile_img) && !empty($user->profile_img))
                unlink($user->profile_img);

            // Set new image to object
            $user->profile_img = $image;
            $user->save();
        }

        return response()->json([
            'token' => $user->newToken(),
            'profile' => $user->toArray(),
            'errors' => ''
        ]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function companyUserRegister(CompanyRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password'),
            'user_type' => 'company_owner',
            'approve_per' => 0,
        ]);

        $user->updateTracker('Sign up');

        if ($user) {
            $company = Company::create([
                'name' => $request->input('company_name'),
                'as_consultant' => $request->input('as_consultant'),
                'industry_type' => $request->input('industry_type'),
                'expire'        => date("Y-m-d", time()),
            ]);

            $user->company_id = $company->id;
            $user->save();

            if($company){
                $company->size = User::where('company_id', $company->id)->get()->count();
                $company->save();
            }
            $company->assigned = true;
            $company->save();

            // Handle image upload
            if ($request->hasFile('image') && !empty($request->file('image'))) {
                $image = $this->imageUpload($request->file('image'), 'images/company_logo');
                //Remove the old image (New image uploaded)
                if (isset($company->upload_company_img) && !empty($company->upload_company_img))
                    unlink($company->upload_company_img);

                // Set new image to object
                $company->upload_company_img = $image;
                $company->save();
            }
            if ($company) {
                return response()->json([
                    'token' => $user->newToken(),
                    'profile' => $user->toArray(),
                    'company' => $company->toArray()
                ], 200);
            }
        }
        return response()->json([
            'error' => true,
            'message' => "Something went wrong, please try again later",
            'errors' => ''
        ], 500);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function consultantUserRegister(ConsultantRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password'),
            'user_type' => 'consultant',
            'approve_per' => 0,
        ]);

        $user->updateTracker('Sign up');

        // Handle image upload
        if ($request->hasFile('image') && !empty($request->file('image'))) {
            $image = $this->imageUpload($request->file('image'), 'images/user_logo');
            //Remove the old image (New image uploaded)
            if (isset($user->profile_img) && !empty($user->profile_img))
                unlink($user->profile_img);

            // Set new image to object
            $user->profile_img = $image;
            $user->save();
        }

        return response()->json([
            'token' => $user->newToken(),
            'profile' => $user->toArray(),
            'errors' => ''
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->getCredentials();

        if (Auth::validate($credentials)) {
            $user = Auth::user();

            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            Auth::login($user, $request->get('remember'));

            $user->updateTracker('Sign in');

            if ($request->get('remember')) :
                $this->setRememberMeExpiration($user);
            endif;

            return response()->json([
                'token' => $user->newToken(),
                'profile' => $user->toArray(),
                'errors' => ''
            ]);
        }

        return response()->json([
            'message' => 'E-mail address or password is incorrect',
            'errors' => ''
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email:rfc,dns|max:255|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if ($user->passwordResetCode()->valid()->exists()) {
            return response()->json(
                ['message' =>  'You can request a code once per ' . PasswordReset::TOKEN_LIFETIME_IN_MINUTE . ' minute'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $passwordResetCode = random_int(100000, 999999);
        $passwordResetCodeCreatedAt = Carbon::now();
        PasswordReset::updateOrCreate(
            [
                'email' => $user->email
            ],
            ['token' => Hash::make($passwordResetCode), 'created_at' => $passwordResetCodeCreatedAt]
        );

        $sended = $user->sendMessage(
            'Set Up A New Password',
            'You recently requested to reset your password for your account. This password reset is only valid for the next 24 hours. You can change your password using the verification code: ' . $passwordResetCode,
            route('resetPassword.get', [app()->getLocale(), 'user']),
            'Reset your password'
        );

        if ($sended)
            return response()->json([
                'message' => 'Verification code sent to your e-mail address successfuly.',
                'password_reset_code_valid_until' =>
                $passwordResetCodeCreatedAt->addDays(PasswordReset::TOKEN_LIFETIME_IN_MINUTE)->format('d-m-Y H:i:s'),
            ]);

        return response()->json(
            ['message' =>  'Cannot send verification code. Try again later.'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|max:255|exists:users,email',
            'verification_code' => 'required|integer',
            'password' => 'required|string|min:5|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $passwordResetCode = $user->passwordResetCode()->tokenValid()->first();

        if (!$passwordResetCode || !Hash::check($request->verification_code, $passwordResetCode->token)) {
            return response()->json(
                ['message' => 'The code is incorrect or expired, please try again.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'Your password has been changed successfully. You can log in using your new password.',
        ]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updateProfile(ProfileRequest $request): JsonResponse
    {
        $user = User::find($request->user_id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile_img = $request->profile_img;

        if(!$user->save())
            return response()->json([
                'profile' => '',
                'message' => 'Cannot update the profile. Please try again later. ',
                'errors' => ''
            ], 500);
        return response()->json([
            'profile' => $user->toArray(),
            'errors' => '',
            'message' => 'Updated'
        ], 200);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function changePassword(PasswordRequest $request): JsonResponse
    {
        $user = User::find($request->user_id);

        if(!Hash::check($request->current_pass, $user->password))
            return response()->json([
                'profile' => '',
                'message' => 'Your current password is wrong!',
                'errors' => ''
            ], 500);

        $user->password = $request->new_password;

        if(!$user->save())
            return response()->json([
                'profile' => '',
                'message' => 'Cannot update the profile. Please try again later. ',
                'errors' => ''
            ], 500);
        return response()->json([
            'profile' => $user->toArray(),
            'errors' => '',
            'message' => 'Updated'
        ], 200);
    }

}
