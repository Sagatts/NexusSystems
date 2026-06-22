<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            /** @var Usuario $user */
            $user = Auth::user();

            switch (strtolower($user->rol)) {

                case 'administrador':
                    return redirect()->route('dashboard');

                case 'garzon':
                case 'cocina':
                    return redirect()->route('pedidos.index');

                default:
                    Auth::logout();
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}