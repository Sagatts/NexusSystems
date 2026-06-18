<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use App\Rules\ValidarRut;
use App\Rules\ValidarCorreo;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Obtenemos el parámetro de la ruta. Puede llegar como el modelo Usuario 
        // (si tienes Route Model Binding configurado) o como un string (el RUT).
        $usuario = $this->route('usuario');
        $rutIgnorar = $usuario instanceof Usuario ? $usuario->rut : $usuario;

        return [
            'rut' => [
                'required',
                'string',
                'max:12',
                // Le decimos explícitamente que valide en la tabla y columna 'rut', 
                // pero ignorando la fila que tenga este mismo $rutIgnorar en la columna 'rut'
                Rule::unique(Usuario::class, 'rut')->ignore($rutIgnorar, 'rut'),
                new ValidarRut(),
            ],
            'nombre' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'max:255',
                // Hacemos exactamente lo mismo para el correo
                Rule::unique(Usuario::class, 'email')->ignore($rutIgnorar, 'rut'),
                new ValidarCorreo(),
            ],
            'contrasena' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'confirmed',
                Rules\Password::defaults(),
            ],
            'rol' => [
                'required',
                'in:administrador,garzon,cocina',
            ],
        ];
    }

    /**
     * Obtiene los mensajes personalizados para errores de validación.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'rut.required' => 'El RUT es requerido.',
            'rut.max' => 'El RUT no puede exceder 12 caracteres.',
            'rut.unique' => 'El RUT ya está registrado en el sistema.',
            'nombre.required' => 'El nombre es requerido.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.lowercase' => 'El correo debe estar en minúsculas.',
            'email.max' => 'El correo no puede exceder 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está registrado en el sistema.',
            'contrasena.required' => 'La contraseña es requerida.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
            'rol.required' => 'El rol es requerido.',
            'rol.in' => 'El rol seleccionado no es válido.',
        ];
    }
}