<?php

namespace App\Http\Requests;

use App\Rules\UniqueMobileNumber;
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


        if ($this->isMethod('post')) {

            return [
                'industrial_city_id' => 'required|exists:industrial_cities,id',
                'name' => 'required|min:3|max:50',
                // 'type' => 'required|in:0,1,2',
                'mobile_number' => ['required','numeric',new UniqueMobileNumber()],
                'datalogger_model' => 'required',
                'status' => 'required|in:0,1',
                'sensor_type' => 'nullable|required_if:entity_type,source',
                'fount_height' => 'nullable|numeric|required_if:entity_type,source',
                'fount_bulk' => 'nullable|numeric|required_if:entity_type,source',
                'yearly_bulk' => 'nullable|numeric|required_if:entity_type,well',
                'flow_rate' => 'nullable|numeric|required_if:entity_type,well',
                // 'checkCode.*' => 'exists:check_codes,id',
                // 'power' => 'nullable|exists:check_codes,id',
            ];
        } else {

           $device = $this->route('device'); // فرض کنید نام پارامتر روت datalogger است

            return [
                'industrial_city_id' => 'required|exists:industrial_cities,id',
                'name' => 'required|min:3|max:50',
                // 'type' => 'required|in:0,1,2',
                'mobile_number' => ['required','numeric',new UniqueMobileNumber($device->id)],
                'datalogger_model' => 'required',
                'sensor_type' => 'nullable|required_if:entity_type,source',
                'fount_height' => 'nullable|numeric|required_if:entity_type,source',
                'fount_bulk' => 'nullable|numeric|required_if:entity_type,source',
                'yearly_bulk' => 'nullable|numeric|required_if:entity_type,well',
                'flow_rate' => 'nullable|numeric|required_if:entity_type,well',
                'checkCode.*' => 'exists:check_codes,id',
                'power' => 'required|exists:check_codes,id',
                'wells.*' => 'nullable|exists:wells,id',
                'pumps.*' => 'nullable|exists:pumps,id',
            ];
        }
    }

    public function attributes()
    {
        return [
            'name' => 'نام تجهیز',
            'type' => 'نوع تجهیز',
            'model' => 'مدل',
        ];
    }

    public function messages()
    {
        return [
            'mobile_number.required' => 'وارد کردن شماره موبایل الزامی است.',
            'mobile_number.numeric' => 'شماره موبایل باید عددی باشد.',
            'mobile_number.digits' => 'شماره موبایل باید ۱۱ رقم باشد.',
            'mobile_number.unique' => 'این شماره موبایل قبلاً ثبت شده است.',
        ];
    }
}
