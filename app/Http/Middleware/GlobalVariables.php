<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Language;
use App\Models\Tos;
use App\Models\Company;
use App\Models\TblReportRequest;

class GlobalVariables
{
    protected $languages = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tos_content = Tos::first();

        if (Schema::hasTable('languages')) {
            $languages = Language::where('active', 1)->get();
            View::share('languages', $languages);

            if(Language::where('language_code', app()->getLocale())->first()){
                $lang_id = Language::where('language_code', app()->getLocale())->first()->id;
                $tos_content = Tos::where('language_id', $lang_id)->first();
            }

            View::share('tos_content', $tos_content);

            $company = '';
            $logo_image = url('images/default-company.png');
            $data_pedning_tickets = '';
            $user_profile = '';
            $user = '';
            $admin = '';
            $notifications = '';

            if (isset(auth()->user()->company_id))
                $company = Company::find(auth()->user()->company_id);

            if (
                auth()->check() && (auth()->user()->user_type == 'admin_super' ||
                    auth()->user()->user_type == 'admin_support')
            ) {
                $admin = auth()->user();
                $admin_info = auth()->user();
                $user_profile = $admin_info->upload_admin_img;
                $data_pedning_tickets = TblReportRequest::where('status', 0)->get();
                $notifications = auth()->user()->unreadNotifications;
            }

            if( auth()->check()) {
                $user = auth()->user();
                $logo_image = !empty($user->profile_img) ? $user->profile_img : url('images/default-company.png');
                $data_pedning_tickets = TblReportRequest::where('user_id', $user->id)->get();
                $user_profile = $user->profile_img;

                $notifications = auth()->user()->unreadNotifications;
            }

            $language = Language::where('language_code', app()->getLocale())->first();

            $languages = Language::where('active', 1)->get();

            View::share('company', $company);
            View::share('logo_image', $logo_image);
            View::share('user_profile', $user_profile);
            View::share('data_pedning_tickets', $data_pedning_tickets);
            View::share('user', $user);
            View::share('admin', $admin);
            View::share('notifications', $notifications);
            View::share('language', $language);
            View::share('languages', $languages);
        }

        return $next($request);
    }
}
