<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Mostrar formulario de restablecimiento.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'request' => $request
        ]);
    }

    /**
     * Procesar el cambio de contraseña.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function (Usuario $user) use ($request) {

                $user->forceFill([
                    'contrasena' => Hash::make($request->password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET

            ? redirect()->route('login')
                ->with('status', __($status))

            : back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => __($status),
                ]);
    }
}