<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechnicianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'tax_id' => 'nullable|string|max:50',
            'specialty' => 'required|string|max:150',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'availability' => 'required|in:available,busy,off',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede tener más de 150 caracteres.',

            'tax_id.string' => 'El CIF/NIF debe ser texto.',
            'tax_id.max' => 'El CIF/NIF no puede tener más de 50 caracteres.',

            'specialty.required' => 'La especialidad es obligatoria.',
            'specialty.string' => 'La especialidad debe ser texto.',
            'specialty.max' => 'La especialidad no puede tener más de 150 caracteres.',

            'phone.string' => 'El teléfono debe ser texto.',
            'phone.max' => 'El teléfono no puede tener más de 20 caracteres.',

            'email.email' => 'El email debe ser un correo válido.',
            'email.max' => 'El email no puede tener más de 100 caracteres.',

            'availability.required' => 'La disponibilidad es obligatoria.',
            'availability.in' => 'La disponibilidad debe ser: available, busy u off.',
        ];
    }
}
