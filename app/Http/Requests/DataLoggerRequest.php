<?php

namespace App\Http\Requests;

use App\Rules\MobileNumber;
use Illuminate\Foundation\Http\FormRequest;

class DataLoggerRequest extends FormRequest
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
            'name' => 'required|min:3|max:50',
            'type' => 'required|in:0,1,2',
            'mobile_number'=> ['required','numeric',new MobileNumber],
            'model' => 'required',
            'key_type' =>'required|in:1,2',
            'sensor_type' =>'required',
            'city_id'=> 'required|exists:cities,id',
            'status'=> 'required|in:0,1',
            'fount_height' => 'required|numeric',
            'fount_bulk' => 'required|numeric',
            'yearly_bulk' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام تجهیز',
            'type' =>'نوع تجهیز',
            'model' => 'مدل',
        ];
    }
}
