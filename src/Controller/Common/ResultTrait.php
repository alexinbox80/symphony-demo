<?php

namespace App\Controller\Common;

trait ResultTrait
{
    private ?string $message = null;

    private bool $success;

    private ?int $code = null;

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }
}
