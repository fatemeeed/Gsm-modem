<?php

namespace App\Rules;

use App\Models\DataloggerOrderCode;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class uniqueDataloggerOrderCode implements ValidationRule
{
    protected $dataloggerId;
    

    public function __construct($dataloggerId)
    {

        $this->dataloggerId = $dataloggerId;
       
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DataloggerOrderCode::where('datalogger_id', $this->dataloggerId)
        ->where('order_code_id', $value)->exists();

        if ($exists) {
            $fail(' کد کنترل  وارد شده قبلاً ثبت شده است.');
        };
    }
}
