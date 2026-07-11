<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Rules\ValidarRut;
use App\Rules\ValidarCorreo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Primero formateamos el RUT
        $rutFormateado = $this->formatearRut($request->rut);

        // Validamos con el RUT formateado
        $request->merge(['rut' => $rutFormateado]);

        $request->validate([
            'rut' => ['required', 'string', 'max:12', 'unique:'.Usuario::class, new ValidarRut()],
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'max:255', 'unique:'.Usuario::class, new ValidarCorreo()],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol' => ['required', 'in:administrador,garzon,cocina'],
        ]);

        $user = Usuario::create([
            'rut' => $rutFormateado,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasena' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Formatea un RUT al formato sin puntos (12345678-9).
     */
    private function formatearRut(?string $rut): ?string
    {
        if (empty($rut)) {
            return null;
        }

        // Limpiamos el RUT
        $rutLimpio = preg_replace('/[^0-9kK]/', '', strtoupper($rut));

        if (strlen($rutLimpio) < 8 || strlen($rutLimpio) > 9) {
            return $rut; // No formateamos si no es válido
        }

        $numero = substr($rutLimpio, 0, -1);
        $dv = substr($rutLimpio, -1);

        // Formateamos SIN puntos
        return "{$numero}-{$dv}";
    }
}
