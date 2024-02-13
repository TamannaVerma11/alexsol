<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcceptInviteRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\HTTP\Requests\Register\UserRegisterRequest;
use App\HTTP\Requests\UserInviteRequest;
use App\Models\IndustryContent;
use App\Models\IndustryType;
use App\Models\Invitation;
use App\Models\Language;
use App\Models\Package;
use App\Models\PackageContent;
use App\Models\Text;
use Illuminate\Support\Facades\Auth;
use App\HTTP\Requests\CompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(10);
        return view('front.user.company.companies', compact(['companies']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantCompanies()
    {
        $companies = Company::where('id', auth()->user()->company_id)->get();
        return view('front.user.company.companies', compact(['companies']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($langcode, Company $item)
    {
        $company = $item;
        $package_classes = null;
        $language = Language::where('language_code', $langcode)->first();
        if (!$company && empty($company->id) && !$language && empty($language)) {
            return redirect()->back()->with('error', trans("index.user_industry_phrase6"));
        }

        $company_owner = User::where([['company_id', $company->id], ['user_type', 'company_owner']])->first();
        $industry_type = IndustryContent::where([['industry_id', $company->industry_type], ['language_id', $language->id]])->first();
        $package_data = Package::find($company->package_id);
        $report_content = Text::where([['company_id', $company->id], ['language_id', $language->id], ['selector', 'general_report_text']])->first();
        $company_users = User::where('company_id', $company->id)->get();
        $industry_type_data = IndustryContent::get();
        $package_content = ($package_data) ? PackageContent::where([['package_id', $package_data->id], ['language_id', $language->id]])->first() : null;
        $industry_types = IndustryType::get();
        $packages = Package::orderBy('size_min', 'ASC')->get();

        if ($packages) {
            $package_classes = array();
            $min_max = array('min' => array(), 'max' => array());
            foreach ($packages as $package) {
                $class_exist = false;
                if (!in_array($package->size_min, $min_max['min'])) {
                    array_push($min_max['min'], $package->size_min);
                    $class_exist = $class_exist | true;
                }

                if (!in_array($package->size_max, $min_max['max'])) {
                    array_push($min_max['max'], $package->size_max);
                    $class_exist = $class_exist | true;
                }

                if ($class_exist)
                    array_push($package_classes, $package);
            }
        }
        return view('front.user.company.company_profile', compact([
            'company', 'industry_type', 'company_owner',
            'package_data', 'report_content', 'company_users',
            'industry_type_data', 'package_content', 'packages',
            'package_classes', 'industry_types'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function profile($langcode)
    {
        $user = User::find(auth()->user()->id);
        if ($user->user_type != 'company_owner')
            return redirect()->back()->with('error', 'You are not authorized to view this page!');

        $company = Company::find($user->company_id);
        $package_classes = null;
        $language = Language::where('language_code', $langcode)->first();
        if (!$company && empty($company->id) && !$language && empty($language)) {
            return redirect()->back()->with('error', trans("index.user_industry_phrase6"));
        }

        $company_owner = User::where([['company_id', $company->id], ['user_type', 'company_owner']])->first();
        $industry_type = IndustryContent::where([['industry_id', $company->industry_type], ['language_id', $language->id]])->first();
        $package_data = Package::find($company->package_id);
        $report_content = Text::where([['company_id', $company->id], ['language_id', $language->id], ['selector', 'general_report_text']])->first();
        $company_users = User::where('company_id', $company->id)->get();
        $industry_type_data = IndustryContent::get();
        $package_content = ($package_data) ? PackageContent::where([['package_id', $package_data->id], ['language_id', $language->id]])->first() : null;
        $industry_types = IndustryType::get();
        $packages = Package::orderBy('size_min', 'ASC')->get();

        if ($packages) {
            $package_classes = array();
            $min_max = array('min' => array(), 'max' => array());
            foreach ($packages as $package) {
                $class_exist = false;
                if (!in_array($package->size_min, $min_max['min'])) {
                    array_push($min_max['min'], $package->size_min);
                    $class_exist = $class_exist | true;
                }

                if (!in_array($package->size_max, $min_max['max'])) {
                    array_push($min_max['max'], $package->size_max);
                    $class_exist = $class_exist | true;
                }

                if ($class_exist)
                    array_push($package_classes, $package);
            }
        }
        return view('front.user.company.company_profile', compact([
            'company', 'industry_type', 'company_owner',
            'package_data', 'report_content', 'company_users',
            'industry_type_data', 'package_content', 'packages',
            'package_classes', 'industry_types'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update($langcode, Company $item, CompanyRequest $request)
    {
        $company = $item;
        // Handle image upload
        $image = $company->upload_company_img;
        if ($request->hasFile('upload_company_img') && !empty($request->file('upload_company_img'))) {
            $image = $this->imageUpload($request->file('upload_company_img'), '/images/company_logo');
            if (isset($company->upload_company_img) && !empty($company->upload_company_img) && is_file($company->upload_company_img))
                unlink($company->upload_company_img);
        }

        $newReq = array_merge($request->all(), [
            'upload_company_img' => $image,
            'company_id' => $company->id,
            'user_id' => auth()->user()->id
        ]);
        $response = Http::accept('application/json')->post(route('api.company.update'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("company.edit", [$langcode, $company->id])
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function updateProfile($langcode, CompanyRequest $request)
    {
        $company = Company::find(auth()->user()->company_id);

        // Handle image upload
        $image = '';
        if ($request->hasFile('upload_company_img') && !empty($request->file('upload_company_img'))) {
            $image = $this->imageUpload($request->upload_company_img, '/images/company_logo');
        }

        $newReq = array_merge($request->all(), [
            'upload_company_img' => $image,
            'company_id' => $company->id,
            'user_id' => auth()->user()->id
        ]);
        $response = Http::accept('application/json')->post(route('api.company.update'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("company.profile", [$langcode])
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($langcode, Company $item)
    {
        $item->delete();

        return redirect(route('company.index', $langcode))->with('success', 'Success');
    }

    /**
     * Activate company
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($langcode, Company $item)
    {
        if (auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'admin_support') {
            $item->status = 'active';
            $item->save();
            return response()->json([
                "status" => true,
                "redirect" => route("company.edit", [$langcode, $item->id])
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => 'You do not have the necessary permissions to this operation!',
            'errors' =>  ''
        ]);
    }

    /**
     * Renew company
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function renew($langcode, Company $item)
    {
        $company = $item;
        if (auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'admin_support') {
            $next_expire = Date("Y-m-d");
            if (strtotime($company->expire) > time())
                $next_expire = Date("Y-m-d", strtotime($company->expire . " + " . $company->payment_cycle . " months"));
            else
                $next_expire = Date("Y-m-d", strtotime(" + " . $company->payment_cycle . " months"));

            $company->expire = $next_expire;
            $company->save();
            return response()->json([
                "status" => true,
                "redirect" => route("company.edit", [$langcode, $item->id])
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => 'You do not have the necessary permissions to this operation!',
            'errors' =>  ''
        ]);
    }

    /**
     * Suspend company
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function suspend($langcode, Company $item)
    {
        if (auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'admin_support') {
            $item->status = 'suspended';
            $item->save();
            return response()->json([
                "status" => true,
                "redirect" => route("company.edit", [$langcode, $item->id])
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => 'You do not have the necessary permissions to this operation!',
            'errors' =>  ''
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users($langcode)
    {
        $company_users = User::where('company_id', auth()->user()->company_id)->paginate(10);
        return view('front.user.company.users', compact(['company_users']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_user($langcode)
    {
        $company_users = User::where('company_id', auth()->user()->company_id)->paginate(10);
        return view('front.user.company.add_user', compact(['company_users']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_add_user($langcode, UserRegisterRequest $request): JsonResponse
    {
        if (auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'company_owner') {
            $response = Http::accept('application/json')->post(route('api.user.register'), $request->all());

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
        return response()->json([
            "status" => false,
            "message" => 'You do not have the necessary permissions to this operation!',
            'errors' =>  ''
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invite($langcode)
    {
        $invited_users = Invitation::where([['company_id', auth()->user()->company_id]])->paginate(10);
        return view('front.user.company.invite_user', compact(['invited_users']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_invite($langcode, UserInviteRequest $request): JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.company.user.invite'), $request->all());

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("company.users.invite", $langcode),
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invited_users($langcode, Invitation $item)
    {
        $invitation = $item;
        return view('front.invited', compact(['invitation']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function module($langcode, Company $item)
    {
        $company = $item;
        $packages = null;
        $user = User::find(auth()->user()->id);
        $package_classes = array();
        $language = Language::where('language_code', $langcode)->first();
        if (($user->user_type == 'admin_super' || $user->user_type == 'admin_support') ||
            ($user->user_type == 'company_owner' && $user->company_id == $item->id) && !empty($language->id)
        ) {
            $package = Package::find($company->package_id);
            $packages = Package::get();


            $min_max = array('min' => array(), 'max' => array());
            if ($packages) {
                foreach ($packages as $package) {
                    $class_exist = false;
                    if (!in_array($package->size_min, $min_max['min'])) {
                        array_push($min_max['min'], $package->size_min);
                        $class_exist = $class_exist | true;
                    }

                    if (!in_array($package->size_max, $min_max['max'])) {
                        array_push($min_max['max'], $package->size_max);
                        $class_exist = $class_exist | true;
                    }

                    if ($class_exist)
                        array_push($package_classes, $package);
                }
            }

            $package_classes = json_encode($package_classes);

            return view('front.user.company.company_module', compact(['company', 'package', 'packages', 'package_classes']));
        }
        return redirect()->back()->with('error', 'Cannot authorize!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function package_updater($langcode, Request $request)
    {
        $min_max = $request['min_max'];
        $packages = Package::orderBy('price', 'ASC')->get();
        $options = array();
        $language = Language::where('language_code', $langcode)->first();

        if ($packages) {
            foreach ($packages as $package) {
                if ($package->size_min == $min_max['min'] && $package->size_max == $min_max['max']) {
                    $package_name = $package->name;
                    $package_details = $package->details;
                    $package_data = PackageContent::where([['package_id', $package->id], ['language_id', $language->id]])->first();
                    if ($package_data) {
                        $package_name = $package_data->name;
                        $package_details = $package_data->details;
                    }
                    $option = array(
                        "package_id" => $package->id,
                        "name" => $package_name,
                        "price" => $package->price,
                        "user" => $package->user,
                        "details" => $package_details
                    );
                    array_push($options, $option);
                }
            }
        }
        return json_encode($options);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function package_save($langcode, Request $request)
    {
        $company = Company::find($request->company_id);
        if (!empty($company->id)) {
            $company->package_id = $request->package_id;
            if($company->save()){
                if(auth()->user()->user_type == 'company_owner')
                    $redirect = route("company.profile", [$langcode]);
                else
                    $redirect = route("company.edit", [$langcode, $request->company_id]);
                return response()->json([
                    "status" => true,
                    "redirect" => $redirect
                ]);
            }
            else
                return response()->json([
                    "status" => false,
                    "message" => 'An error occured, please try again later.',
                    'errors' =>  ''
                ]);
        }
        return response()->json([
            "status" => false,
            "message" => 'You do not have the necessary permissions to this operation!',
            'errors' =>  ''
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invite_accepted($langcode, AcceptInviteRequest $request): JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.company.user.invite_accepted'), $request->all());

        $res = $response->json();
        if ($response->successful()) {
            $user  = User::find($res['profile']['id']);
            Auth::login($user, $request->get('remember'));
            return response()->json([
                "status" => true,
                "redirect" => route("home.index", $langcode),
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_destroy($langcode, User $item)
    {
        if (auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'company_owner') {
            if (auth()->user()->id != $item->id) {
                $item->delete();
                return redirect()->back()->with('success', 'Success');
            }
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }
        return redirect()->back()->with('error', 'You do not have the necessary permissions to this operation!');
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
