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
            'contact'  => ['required', 'string', 'max:150'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'email'    => ['nullable', 'email', 'max:100'],
            'address'  => ['required', 'string', 'max:255'],
            'history'  => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 150 caracteres.',

            'tax_id.max' => 'El CIF / NIF no puede superar los 50 caracteres.',

            'contact.required' => 'La persona de contacto es obligatoria.',
            'contact.max' => 'La persona de contacto no puede superar los 150 caracteres.',

            'phone.max' => 'El teléfono no puede superar los 20 caracteres.',

            'email.email' => 'El email debe ser una dirección válida.',
            'email.max' => 'El email no puede superar los 100 caracteres.',

            'address.required' => 'La dirección es obligatoria.',
            'address.max' => 'La dirección no puede superar los 255 caracteres.',
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
