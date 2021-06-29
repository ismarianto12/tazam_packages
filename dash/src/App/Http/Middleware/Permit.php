<?php

namespace Bryanjack\Dash\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Permit
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (Auth::user()->can(Route::currentRouteName())) {
            return $response;
        } else {
            return redirect()->route('dash.index');
        }
    }
}
