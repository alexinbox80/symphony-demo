<?php

namespace App\Controller\Common;

class ErrorResponse
{
    use ResultTrait;

    public function __construct(string $message, int $code)
    {
        $this->setSuccess(false);
        $this->setMessage($message);
        $this->setCode($code);
    }
}
