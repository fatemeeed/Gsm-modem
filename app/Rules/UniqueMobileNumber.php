<?php

namespace App\Rules;

use App\Models\Datalogger;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueMobileNumber implements ValidationRule
{
    protected $currentId;

    public function __construct($currentId = null)
    {
        $this->currentId = $currentId;
    }
    

    /**
     * Create a new rule instance.
     *
     * @param int|null $currentId
     */
    // public function __construct($currentId = null)
    // {
    //     $this->currentId = $currentId;
    // }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Datalogger::where('mobile_number', $value)->whereNull('deleted_at');
        if ($this->currentId) {
           
            $query->where('id', '!=', $this->currentId); // رکورد فعلی را نادیده بگیرد
        }

        if ($query->exists()) {
            $fail('شماره موبایل وارد شده قبلاً ثبت شده است.');
        }
    }
}
