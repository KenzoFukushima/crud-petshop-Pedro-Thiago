<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsNotLogged
{

    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user')) {
            return session('user.role') === 'admin'
                ? redirect()->route('dashboard')
                : redirect()->route('home.dono');
        }

        return $next($request);
    }
}
