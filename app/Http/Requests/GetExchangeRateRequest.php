<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetExchangeRateRequest extends FormRequest
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
            'date' => 'sometimes|date|before_or_equal:today',
            'currency' => 'sometimes|string|in:USD,AUD,CAD,GBP',
        ];
    }
}
