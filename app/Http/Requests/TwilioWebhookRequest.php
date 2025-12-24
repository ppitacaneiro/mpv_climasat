<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TwilioWebhookRequest extends FormRequest
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
            'From'       => 'required|string',
            'To'         => 'required|string',
            'Body'       => 'required|string',
            'MessageSid' => 'required|string',
            'ProfileName' => 'sometimes|string',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Log::channel('whatsapp_ticket')->warning(
            'Invalid Twilio webhook payload',
            $validator->errors()->toArray()
        );

        response()->json(['status' => 'ok'], 200)->send();
        exit;
    }
}
