<?php

namespace App\Exceptions;

use Exception;

class GSMConnectionNotFoundException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "امکان اتصال به مودم فراهم نیست ، لطفا تنظیمات پورت را چک کنید", $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return response()->view('errors.custome', [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
        ], $this->getCode());
    }
}
