<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndustrialRequest extends FormRequest
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
            'name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'status'  => 'required|numeric|in:0,1'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام شهرک صنعتی'
        ];
    }
}
