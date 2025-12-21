<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:150'],
            'tax_id'   => ['nullable', 'string', 'max:50'],
            'contact'  => ['nullable', 'string', 'max:150'],
            'phone'    => ['required', 'string', 'max:20'],
            'email'    => ['nullable', 'email', 'max:100'],
            'address'  => ['nullable', 'string', 'max:255'],
            'history'  => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string'   => 'El nombre debe ser una cadena de texto.',
            'name.max'      => 'El nombre no debe exceder los 150 caracteres.',
            'tax_id.string' => 'El CIF / NIF debe ser una cadena de texto.',
            'tax_id.max'    => 'El CIF / NIF no debe exceder los 50 caracteres.',
            'contact.string'=> 'La persona de contacto debe ser una cadena de texto.',
            'contact.max'   => 'La persona de contacto no debe exceder los 150 caracteres.',
            'phone.required'=> 'El teléfono es obligatorio.',
            'phone.string'  => 'El teléfono debe ser una cadena de texto.',
            'phone.max'     => 'El teléfono no debe exceder los 20 caracteres.',
            'email.email'   => 'El email debe ser una dirección de correo válida.',
            'email.max'     => 'El email no debe exceder los 100 caracteres.',
            'address.string'=> 'La dirección debe ser una cadena de texto.',
            'address.max'   => 'La dirección no debe exceder los 255 caracteres.',
            'history.string'=> 'El historial debe ser una cadena de texto.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'tax_id' => 'CIF / NIF',
            'contact' => 'persona de contacto',
            'phone' => 'teléfono',
            'email' => 'email',
            'address' => 'dirección',
            'history' => 'historial',
        ];
    }
}
