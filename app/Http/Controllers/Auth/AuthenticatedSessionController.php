<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Usuario;
use Illuminate\Support\Facades\Cookie;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        session()->flash('login_reciente', true); // sesion fantasma para abrir alertas

        if ($request->has('remember')) {
        // Guarda el RUT por 1 año (525600 minutos)
        Cookie::queue('remember_rut', $request->rut, 525600);
        } else {
            // Si no marcó la casilla, eliminamos el RUT recordado
            Cookie::queue(Cookie::forget('remember_rut'));
        }

        /** @var Usuario $user */
        $user = Auth::user();

        switch ($user->rol) {

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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
