<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class EntityAlreadyExistException extends Exception implements HttpCompliantExceptionInterface
{
    public function getHttpCode(): int
    {
        return Response::HTTP_CONFLICT;
    }

    public function getHttpResponseBody(): string
    {
        return 'Entity already exist!';
    }
}
