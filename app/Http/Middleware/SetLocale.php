<?php

namespace App\Http\Middleware;

use App\Services\Company\CompanyService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class SetLocale
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   app()->setLocale('id');
        if($request->segment(1)=='en'){app()->setLocale($request->segment(1));}
        URL::defaults(['locale' =>app()->getLocale()]);
        return $next($request);
    }
}
