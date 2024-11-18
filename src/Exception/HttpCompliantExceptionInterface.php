<?php

namespace App\Exception;

interface HttpCompliantExceptionInterface
{
    public function getHttpCode(): int;

    public function getHttpResponseBody(): string;
}
