<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCodeRequest extends FormRequest
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
            'order' =>'min:2|regex:/^[A-Z]+$/u',
            'name' => 'required|max:120|min:2',
            'description' => 'required|max:200|min:2'
        ];
    }

    public function messages()
    {
       return [ 'order.regex' => 'فقط استفاده از حروف بزرگ مجاز است'];
    }

   
}
