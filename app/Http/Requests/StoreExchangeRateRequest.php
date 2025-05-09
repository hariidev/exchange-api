<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExchangeRateRequest extends FormRequest
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
            'date' => 'required|date|date|before_or_equal:today',
            'base_currency' => 'required|string|in:USD,AUD,CAD,GBP,LKR',
            'target_currency' => 'required|string|in:USD,AUD,CAD,GBP,LKR',
            'rate' => 'required|min:0|numeric'
        ];
    }
}
