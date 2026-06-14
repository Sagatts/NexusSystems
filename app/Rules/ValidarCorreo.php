<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidarCorreo implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $correo = trim($value);

        // Validar que no esté vacío
        if (empty($correo)) {
            $fail('El :attribute es requerido.');
            return;
        }

        // Validar longitud
        if (strlen($correo) > 255) {
            $fail('El :attribute no puede exceder 255 caracteres.');
            return;
        }

        // Validar formato con regex
        $patron = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
        if (!preg_match($patron, $correo)) {
            $fail('El :attribute debe tener un formato válido (ej: usuario@ejemplo.com).');
            return;
        }

        // Dividir en partes (usuario@dominio.com)
        $partes = explode('@', $correo);
        if (count($partes) !== 2) {
            $fail('El :attribute debe contener exactamente un símbolo @.');
            return;
        }

        $usuario = $partes[0];
        $dominio = $partes[1];

        // Validar parte del usuario (no puede tener caracteres especiales inválidos)
        if (!preg_match('/^[a-zA-Z0-9._%-]+$/', $usuario)) {
            $fail('La parte del usuario en :attribute contiene caracteres no permitidos.');
            return;
        }

        // Validar que no empiece o termine con punto
        if (strpos($usuario, '.') === 0 || strrpos($usuario, '.') === strlen($usuario) - 1) {
            $fail('El usuario en :attribute no puede empezar o terminar con un punto.');
            return;
        }

        // Validar que no tenga puntos consecutivos
        if (strpos($usuario, '..') !== false) {
            $fail('El usuario en :attribute no puede contener puntos consecutivos.');
            return;
        }

        // Validar dominio
        if (!preg_match('/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $dominio)) {
            $fail('El dominio en :attribute debe tener un formato válido.');
            return;
        }

        // Validar que no haya puntos consecutivos en el dominio
        if (strpos($dominio, '..') !== false) {
            $fail('El dominio en :attribute no puede contener puntos consecutivos.');
            return;
        }

        // Validar que no empiece con punto
        if (strpos($dominio, '.') === 0) {
            $fail('El dominio en :attribute no puede empezar con un punto.');
            return;
        }

        // Validar extensión mínima
        $extensionDominio = substr($dominio, strrpos($dominio, '.') + 1);
        if (strlen($extensionDominio) < 2) {
            $fail('La extensión del dominio en :attribute debe tener al menos 2 caracteres.');
            return;
        }
    }
}
