<?php

namespace App\Exceptions;

use Exception;

class ResponseException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message, $code)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function render()
    {
        return response()->error($this->message, $this->code);
    }
}
