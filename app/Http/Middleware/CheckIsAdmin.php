<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user.role') !== 'admin') {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}
