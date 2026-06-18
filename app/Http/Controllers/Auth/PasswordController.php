<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => [
                'required',
                'current_password'
            ],

            'password' => [
                'required',
                'confirmed',

                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'current_password.required' =>
                'Debe ingresar su contraseña actual.',

            'current_password.current_password' =>
                'La contraseña actual es incorrecta.',

            'password.required' =>
                'Debe ingresar una nueva contraseña.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',
        ]);

        $request->user()->update([
            'contrasena' => Hash::make($validated['password']),
        ]);

        return back()->with(
            'success',
            'Contraseña actualizada correctamente'
        );
    }
}
