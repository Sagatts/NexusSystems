<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            $user = auth()->user();

            switch ($user->rol) {

                case 'administrador':
                    return redirect()->route('dashboard');

                case 'garzon':
                case 'cocina':
                    return redirect()->route('pedidos.index');

                default:
                    auth()->logout();
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}