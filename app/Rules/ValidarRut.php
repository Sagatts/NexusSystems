<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidarRut implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rut = str_replace(['.', ' '], '', $value);

        if (!str_contains($rut, '-')) {
            $fail('El :attribute debe tener el formato correcto (ej: 12345678-9).');
            return;
        }

        $parts = explode('-', $rut);
        if (count($parts) !== 2) {
            $fail('El :attribute debe tener el formato correcto (ej: 12345678-9).');
            return;
        }

        $numero = $parts[0];
        $verificador = strtoupper($parts[1]);

        if (!is_numeric($numero) || strlen($numero) < 7 || strlen($numero) > 8) {
            $fail('El :attribute debe contener un número válido de 7 u 8 dígitos.');
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
