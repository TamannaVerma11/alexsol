<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Http\Request;

class RedirectLanguageCode
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
        foreach (\App\Models\Language::where('active', 1)->get() as $lang) {
            array_push($this->languages, $lang->language_code);
        }

        if (is_array($this->languages) && sizeof($this->languages) > 0 && !empty($request->route('lang'))) {
            $language = \App\Models\Language::where('language_code', $request->route('lang'))->first();

            if ($language != null) {
                if ((Cookie::get('lang') != null && Cookie::get('lang') != $language->language_code) || Cookie::get('lang') == null) {
                    Cookie::queue(Cookie::forget('lang'));
                    Cookie::queue(Cookie::make('lang', "$language->language_code", 25000));

                    //return $next($request)->withCookie('lang', $language->language_code, 25000);
                }

                app()->setLocale($language->language_code);
                session()->put('lang', $language->language_code);

                return $next($request);
            }

            if (Cookie::get('lang') != null)
                $language_code = Cookie::get('lang');
            else {
                $language_code = app()->getLocale();
            }

            $params = explode('/', request()->path());
            $language = $params[0];



            if (!in_array($language, $this->languages)) {
                app()->setLocale($language_code);
                session()->put("lang", $language_code);

                return redirect($language_code . '/' . request()->path(), 301);
            }

            abort(404);
        }

        return $next($request);
    }
}
