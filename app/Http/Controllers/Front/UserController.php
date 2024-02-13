<?php

namespace App\Http\Controllers\Front;

use App\HTTP\Requests\Register\ConsultantRegisterRequest;
use App\HTTP\Requests\Register\CompanyRegisterRequest;
use App\HTTP\Requests\Register\UserRegisterRequest;
use App\HTTP\Requests\ProfileRequest;
use App\Services\Login\RememberMeExpiration;
use App\HTTP\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;

class UserController extends Controller
{
    use RememberMeExpiration;

    public function index($langcode)
    {

    }

    public function show($langcode, $id)
    {
        return User::find($id);
    }

    /**
     * @param  Request  $request
     * @return
     */
    public function userRegister($langcode, UserRegisterRequest $request): JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.user.register'), $request->all());

        $res = $response->json();
        if ($response->successful()) {
            $user  = User::find($res['profile']['id']);
            Auth::login($user, $request->get('remember'));
            return response()->json([
                "status" => true,
                "redirect" => route("home.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function companyUserRegister($langcode, CompanyRegisterRequest $request): JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.user.company.register'), $request->all());

        $res = $response->json();
        if ($response->successful()) {
            $user  = User::find($res['profile']['id']);
            Auth::login($user, $request->get('remember'));
            return response()->json([
                "status" => true,
                "redirect" => route("home.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' => $res['errors'] ?? ''
        ]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function consultantUserRegister($langcode, ConsultantRegisterRequest $request): JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.user.consultant.register'), $request->all());

        $res = $response->json();
        if ($response->successful()) {
            $user  = User::find($res['profile']['id']);
            Auth::login($user, $request->get('remember'));
            return response()->json([
                "status" => true,
                "redirect" => route("home.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    public function update($langcode, Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($langcode, Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login($langcode, LoginRequest $request): JsonResponse
    {
        // dd();
        // $response = Http::accept('application/json')->post(route('api.user.login'), $request->all());

        // $res = $response->json();
        // dd($response);
        if (1) {
            $credentials = $request->getCredentials();
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
// dd($user);
            Auth::login($user, $request->get('remember'));

            return response()->json([
                "status" => true,
                "redirect" => route("home.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /*
    * Log out function
    */
    protected function logout($langcode)
    {
        Auth::logout();

        return redirect(route("home.index", $langcode));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function forgotPassword($langcode, Request $request): JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.user.forgotPassword'), $request->all());

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("home.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Show update password form
     * @return view
     */
    public function showResetPass($langcode, $usr)
    {
        return view('front.password_reset', compact('usr'));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updatePassword($langcode, Request $request): JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.user.updatePassword'), $request->all());

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("home.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Show update password form
     * @return view
     */
    public function profile($langcode)
    {
        $user = User::find(auth()->user()->id);
        $company  = Company::find($user->company_id);
        if(!$user && empty($user->id) && !$company && empty($company->id))
            return redirect()->back()->with('error', 'You don\'t have access to this page!');
        return view('front.user.profile.profile', compact('user', 'company'));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updateProfile($langcode, ProfileRequest $request): JsonResponse
    {
        $user = User::find(auth()->user()->id);

        // Handle image upload
        $image = $user->profile_img;
        if ($request->hasFile('profile_img') && !empty($request->file('profile_img'))){
            $image = $this->imageUpload($request->profile_img, '/images/profilepic');
            //Remove the old image (New image uploaded)
            if ( isset($user->profile_img) && !empty($user->profile_img) && is_file($user->profile_img))
                unlink($user->profile_img);
        }

        $newReq = array_merge($request->all(), ['user_id' => $user->id, 'profile_img' => $image]);
        $response = Http::accept('application/json')->post(route('api.user.updateProfile'), $newReq);

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("user.profile", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Show update password form
     * @return view
     */
    public function password($langcode)
    {
        $user = User::find(auth()->user()->id);

        if(!$user && empty($user->id))
            return redirect()->back()->with('error', 'You don\'t have access to this page!');
        return view('front.user.profile.change_pass', compact('user'));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function changePassword($langcode, PasswordRequest $request): JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $newReq = array_merge($request->all(), ['user_id' => $user->id]);
        $response = Http::accept('application/json')->post(route('api.user.changePassword'), $newReq);

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("user.profile", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Show consultants
     * @return view
     */
    public function consultant($langcode)
    {
        $user = User::find(auth()->user()->id);
        if($user->user_type != 'admin_super' && $user->user_type != 'admin_support'){
            return redirect()->back()->with('error', 'You don\'t have priveleges!');
        }

        $consultants = User::where('user_type', 'consultant')->get();
        return view('front.user.user', compact(['consultants']));
    }

    // Upload post image
    public function imageUpload($img, $prefix)
    {
        $imgName    = md5(time() . $img->getClientOriginalName()) . '.' . $img->getClientOriginalExtension();
        $upload     = $img->move(public_path('/' . $prefix), $imgName);

        if ($upload) {
            $img    = $prefix . '/' . $imgName;
            return $img;
        } else
            return '';
    }
}
