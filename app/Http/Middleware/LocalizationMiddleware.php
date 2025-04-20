<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LocalizationMiddleware
{
    public function handle($request, Closure $next)
    {


        $locale = $request->query('lang', Session::get('locale', config('app.locale')));;
        App::setLocale($locale);
        Session::put('locale', $locale);
        return $next($request);
    }

}