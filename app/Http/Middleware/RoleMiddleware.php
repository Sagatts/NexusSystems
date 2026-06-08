<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Si no ha iniciado sesión, pa' fuera
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Obtenemos al usuario actual
        $user = auth()->user();

        // 3. Verificamos si su 'rol' está dentro de los permitidos en la ruta
        if (!in_array(strtolower($user->rol), $roles)) {
            // Si no tiene el rol, lo devolvemos al inicio con un error 403 (Prohibido)
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        // 4. Si todo está bien, lo dejamos pasar
        return $next($request);
    }
}