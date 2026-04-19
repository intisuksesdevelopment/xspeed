<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->setLocale('id');
        if ($request->segment(1) == 'en') {
            app()->setLocale($request->segment(1));
        }
        URL::defaults(['locale' => app()->getLocale()]);

        return $next($request);
    }
}
