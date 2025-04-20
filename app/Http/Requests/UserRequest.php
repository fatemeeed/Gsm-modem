<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if ($this->isMethod('post')) {

            return [
                'first_name' => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'last_name'  => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'national_code'  => 'required|digits:10|unique:users',
                // 'email'      => 'required|email|string|unique:users',
                'password'   => ['required', 'unique:users', Password::min(8)->letters()->mixedCase()->symbols()->uncompromised(), 'confirmed'],
                'activation' => 'required|numeric|in:0,1',
                'industrial_id' => 'required|exists:industrial_cities,id',
                'role_id'  => 'required|exists:roles,id'

            ];
        } else {

            return [
                'first_name' => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'last_name'  => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'industrial_id' => 'required|exists:industrial_cities,id',
                'role_id'  => 'required|exists:roles,id',
                'national_code'  => ['required', 'digits:10', Rule::unique('users')->where('id', $this->id)],
                // 'email'      =>['required','email','string',Rule::unique('users')->where('id', $this->id)],
            ];
        }
    }

    public function attributes()
    {
        return [
            'industrial_id' => 'شهرک صنعتی'
        ];
    }
}
