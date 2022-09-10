<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->role === 0) {
            return $next($request);
        }

        return Redirect::route('welcome');
    }
}
