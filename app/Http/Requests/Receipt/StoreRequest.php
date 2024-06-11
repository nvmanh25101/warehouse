<?php

namespace App\Http\Requests\Receipt;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['required', 'integer', 'exists:products,id'],
            'quantities' => ['required', 'array'],
            'quantities.*' => ['required', 'integer', 'min:1'],
        ];
    }
}
