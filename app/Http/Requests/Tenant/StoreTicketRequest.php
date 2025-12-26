<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'technician_id' => [
                'nullable',
                'exists:technicians,id',
            ],

            'fault_type_id' => [
                'nullable',
                'exists:fault_types,id',
            ],

            'description' => [
                'required',
                'string',
                'min:10',
            ],

            'status' => [
                'sometimes',
                Rule::in(['open', 'in_progress', 'closed']),
            ],

            'urgency' => [
                'sometimes',
                Rule::in(['low', 'medium', 'high', 'critical']),
            ],

            'suggested_ia_solution' => [
                'nullable',
                'string',
            ],

            'technician_solution' => [
                'nullable',
                'string',
            ],

            'closed_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.exists' => 'El cliente seleccionado no existe.',

            'description.required' => 'La descripción es obligatoria.',
            'description.min' => 'La descripción debe tener al menos :min caracteres.',

            'status.in' => 'El estado del ticket no es válido.',
            'urgency.in' => 'El nivel de urgencia no es válido.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->status === 'closed' && !$this->closed_at) {
            $this->merge([
                'closed_at' => now(),
            ]);
        }
    }
}
