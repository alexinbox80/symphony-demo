<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UnprocessableException extends Exception implements HttpCompliantExceptionInterface
{
    public function getHttpCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    public function getHttpResponseBody(): string
    {
        return $this->getMessage();
    }
}
