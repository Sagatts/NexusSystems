<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use App\Rules\ValidarCorreo;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique(Usuario::class)->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'max:255',
                Rule::unique(Usuario::class)->ignore($this->user()->id),
                new ValidarCorreo(),
            ],
        ];
    }
}
