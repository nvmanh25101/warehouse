<?php

namespace App\Http\Requests\Customer;

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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
            ],
            'city' => [
                'required',
                'string',
                'max:50',
            ],
            'district' => [
                'required',
                'string',
                'max:50',
            ],
            'ward' => [
                'required',
                'string',
                'max:50',
            ],
            'address' => [
                'required',
                'string',
                'max:150',
            ],
            'note' => [
                'nullable',
                'string',
            ],
        ];
    }
}
