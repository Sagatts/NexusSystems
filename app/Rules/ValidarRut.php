<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidarRut implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Limpiamos el RUT: quitamos todo lo que no sea dígito ni K/k
        $rutLimpio = preg_replace('/[^0-9kK]/', '', strtoupper($value));

        if (strlen($rutLimpio) < 8 || strlen($rutLimpio) > 9) {
            $fail('El :attribute debe tener entre 8 y 9 caracteres válidos.');
            return;
        }

        // Separamos el número y el dígito verificador
        $numero = substr($rutLimpio, 0, -1);
        $verificador = substr($rutLimpio, -1);

        if (!is_numeric($numero)) {
            $fail('El :attribute debe contener un número válido.');
            return;
        }

        $dvCalculado = $this->calcularDV($numero);

        if ($verificador !== $dvCalculado) {
            $fail('El dígito verificador del :attribute es inválido.');
            return;
        }
    }

    private function calcularDV(string $numero): string
    {
        $suma = 0;
        $multiplicador = 2;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += (int) $numero[$i] * $multiplicador;
            $multiplicador++;
            if ($multiplicador > 7) {
                $multiplicador = 2;
            }
        }

        $resto = $suma % 11;
        $dv = 11 - $resto;

        return match (true) {
            $dv === 11 => '0',
            $dv === 10 => 'K',
            default => (string) $dv,
        };
    }
}
