<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XssSanitization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      $input = $request->all();
      //die(var_dump($input));
      array_walk_recursive($input, function(&$input) {
        $input = strip_tags($input, '<img>');
        //$input = filter_var($input, FILTER_SANITIZE_STRIPPED);
      });

      $request->merge($input);
      return $next($request);
    }
}
