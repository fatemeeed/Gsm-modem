<?php

namespace App\Http\Requests;

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
        if($this->isMethod('post')){

            return [
                'first_name' => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'last_name'  => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'mobile'     => 'required|digits:11|unique:users',
                'national_code'  => 'required|digits:10|unique:users',
                // 'email'      => 'required|email|string|unique:users',
                'password'   => ['required','unique:users',Password::min(8)->letters()->mixedCase()->symbols()->uncompromised(),'confirmed'],
                'activation' => 'required|numeric|in:0,1' ,
    
            ];

        }
        else{

            return [
                'first_name' => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'last_name'  => 'required|max:120|min:1|regex:/[a-zA-Zا-ی يء]$/u',
                'mobile'     => 'required|digits:11|unique:users',
                'national_code'  => 'required|digits:10|unique:users',
                // 'email'      =>['required','email','string',Rule::unique('users')->where('id', $this->id)],
                
                
               
    
            ];

        }
    }
}
