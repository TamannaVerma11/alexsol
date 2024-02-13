<?php

namespace App\Http\Controllers\API;

use App\HTTP\Requests\UserInviteRequest;
use App\HTTP\Requests\AcceptInviteRequest;
use App\HTTP\Requests\CompanyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\Text;
use App\Models\Tracker;
use App\Models\User;
use Carbon\Carbon;

class CompanyController extends Controller
{
    public function index()
    {
        return Company::all();
    }

    public function show($id)
    {
        return Company::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function invite(UserInviteRequest $request): JsonResponse
    {
        if(!empty($request->input('company_id')) ){
            $company = Company::find($request->input('company_id'));

            if($company->status == 'active' && $company->package_id > 0){

                $company_users = User::where('company_id', $company->id)->get();
                $package = Package::find($company->package_id);

                if($package && $company_users->count()-1 < $package->user){
                    $invite_code = $this->generate_invite_code(16);

                    $invite = Invitation::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone'),
                        'company_id' => $request->input('company_id'),
                        'code' => $invite_code,
                    ]);

                    if($invite){
                        $invite_link = route('company.users.invited', [app()->getLocale(), $invite->id]);

                        $sended = $invite->sendMessage(
                            'Nøgd undersøkelse',

                            'Hei.

                            Du har nå fått invitasjon til å besvare spørsmål om hvordan du opplever ditt arbeidsmiljø i relasjon til de samarbeidsutfordringer som har oppstått. Din arbeidsgiver bør ha informert deg om denne.

                            Kartleggingen er konfidensiell. Kartleggingen etterspør ikke person sensitive data.

                            Om du ved en feil har mottatt denne epost, vennligst gi beskjed til oss ved å besvare denne epost så vil vi slette deg fra denne kartleggingen.

                            Vennlig hilsen, Semje Software AS.

                            invitasjonskode: ' . $invite_code ,

                            $invite_link,

                            'invitasjonskode'
                        );

                        if($sended){
                            return response()->json([
                                'profile' => $invite->toArray(),
                                'errors' => ''
                            ], 200);
                        }

                        return response()->json([
                            'profile' => $invite->toArray(),
                            'message' => 'Cannot send the e-mail. Try again later.',
                            'errors' => ''
                        ], 500);

                    }

                    return response()->json([
                        'profile' => '',
                        'message' => 'Cannot add the invite to the database',
                        'errors' => ''
                    ], 500);
                }
                return response()->json([
                    'profile' => '',
                    'message' => 'Sorry, the user limit has done!',
                    'errors' => ''
                ], 500);
            }
            return response()->json([
                'profile' => '',
                'message' => 'The company\'s status is not active or the company doesn\'t subscribe any package yet !',
                'errors' => ''
            ], 500);

        }
        return response()->json([
            'profile' => '',
            'message' => 'There is no company!',
            'errors' => ''
        ], 500);

    }

    public function invite_accepted(AcceptInviteRequest $request)
    {
        $invite_code = $request->input('code');
        $invitation = Invitation::where('code', $invite_code)->first();

        if($invitation && !empty($invitation->id)){
            $user = User::create([
                'name' => $invitation->name,
                'email' => $invitation->email,
                'phone' => $invitation->phone,
                'password' => $request->input('password'),
                'company_id' => $invitation->company_id,
                'approve_per' => 1,
                'user_type' => 'user',
            ]);
            if($user){
                if(!empty($invitation->company_id)){
                    $company = Company::find($invitation->company_id);
                    if($company){
                        $company->size = User::where('company_id', $company->id)->get()->count();
                        $company->save();
                    }
                }

                $invitation->accept_date = Carbon::now();
                $invitation->status = 1;
                $invitation->save();

                $sended = $user->sendMessage(
                    trans('index.email_title_phrase8') . ' ' . config('app.name'),
                    '<h1>Welcome, '. $user->name .'!</h1>
                    <p>Thanks for trying '.config('app.name').'. We\'re thrilled to have you on board.</p>
                    <br>
                    <p>For reference, here\'s your information:</p>
                    <table class="attributes" width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td class="attributes_content">
                          <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                              <td class="attributes_item"><strong>Registered Email:</strong> '.$user->email.'</td>
                            </tr>
                            <tr>
                              <td class="attributes_item"><strong>Customer ID:</strong> '.$user->id.'</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    ',
                    route('home.index', [app()->getLocale()]),
                    'Go to your profile'
                );

                $user->updateTracker('Sign up');

                return response()->json([
                    'token' => $user->newToken(),
                    'profile' => $user->toArray(),
                    'errors' => ''
                ], 200);
            }
            return response()->json([
                'profile' => '',
                'message' => 'Cannot add the user to our database. Try again later.',
                'errors' => '',
            ], 500);
        }
        return response()->json([
            'profile' => '',
            'message' => 'Invitation code does not match our records!',
            'errors' => '',
        ], 500);

    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(CompanyRequest $request): JsonResponse
    {
        $company = Company::find($request->company_id);
        $user = User::find($request->user_id);

        if($request->input('payment_cycle') == 0)
            return response()->json([
                'profile' => '',
                'message' => 'The given data was invalid.',
                'errors' => ['payment_cycle' =>'The payment cycle is required.'],
            ], 500);

        if($company && $user){
            $company_owner = User::where([['company_id', $company->id], ['user_type', 'company_owner']])->first();
            if($company_owner){
                $company_owner->email = $request->input('email');
                $company_owner->profile_img = $request->upload_company_img;

                if(!empty($request->input('password')))
                    $company_owner->password = $request->input('password');

                $company->name = $request->input('name');
                $company->industry_type = $request->input('industry_type');
                $company->upload_company_img = $request->upload_company_img;
                $company->payment_cycle = $request->input('payment_cycle');

                if($user->user_type == "admin_super" || $user->user_type == "admin_support")
                    $company->show_tickets = $request->input('show_tickets');

                $item = Text::updateOrCreate([
                    'company_id' => $company->id,
                    'language_id' => $request->input('language_id'),
                ],[
                    'selector' => 'general_report_text',
                    'content' => $request->input('report_content'),
                ]);

                if($company_owner->save() && $company->save() && $item){
                    return response()->json([
                        'profile' => $company->toArray(),
                        'errors' => ''
                    ], 200);
                }
                return response()->json([
                    'profile' => '',
                    'message' => 'Cannot save data. Please try again later. ',
                    'errors' => ''
                ], 500);
            }
            return response()->json([
                'profile' => '',
                'message' => 'Cannot save data. Please try again later. ',
                'errors' => ''
            ], 500);
        }
        else
            return response()->json([
                'profile' => '',
                'message' => 'Cannot save data. Please try again later. ',
                'errors' => ''
            ], 500);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updateProfile(CompanyRequest $request): JsonResponse
    {
        $company = Company::find($request->company_id);

        if($company){
            $company->color = $request->input('color');
            $company->company_id = $request->input('company_id');
            $company->restriction = $request->input('restriction');

            if($company->save()){
                return response()->json([
                    'profile' => $company->toArray(),
                    'errors' => ''
                ], 200);
            }
            return response()->json([
                'profile' => '',
                'message' => 'Cannot save data. Please try again later. ',
                'errors' => ''
            ], 500);
        }
        else
            return response()->json([
                'profile' => '',
                'message' => 'Cannot save data. Please try again later. ',
                'errors' => ''
            ], 500);
    }

    public function delete(Request $request, $id)
    {
        $user = Company::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
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

    private function generate_invite_code($length)
    {
        $array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $text = '';

        for ($x = 0; $x < $length; $x++) {
            $random = rand(0, 61);
            $text .= $array[$random];
        }
        return $text;
    }
}
