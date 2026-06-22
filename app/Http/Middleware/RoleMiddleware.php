<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Usuario;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var Usuario $user */
        $user = Auth::user();

        if (!in_array(strtolower($user->rol), $roles)) {

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