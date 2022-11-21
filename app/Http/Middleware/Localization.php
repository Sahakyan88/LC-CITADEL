<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Auth::user() ? Auth::user()->language : 'am';
        
        if (! in_array($locale, ['am','en', 'ru'] )) {
            abort(400);
        }
     
        App::setLocale($locale);
        return $next($request);
    }
}
