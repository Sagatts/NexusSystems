<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('usuario', 'email')
                    ->ignore($request->user()->id),
            ],
        ], [

            'nombre.required' =>
                'Debe ingresar un nombre.',

            'email.required' =>
                'Debe ingresar un correo electrónico.',

            'email.email' =>
                'Debe ingresar un correo válido.',

            'email.unique' =>
                'Este correo electrónico ya está registrado.',
        ]);

        $request->user()->update([
            'nombre' => $request->nombre,
            'email'  => $request->email,
        ]);

        return back()->with(
            'success',
            'Perfil actualizado correctamente.'
        );
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')
            ->with('success', 'Perfil actualizado correctamente');
    }
}
