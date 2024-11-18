<?php

namespace App\Controller\Api\V1\Output;

use App\Controller\Common\ResultTrait;
use Symfony\Component\HttpFoundation\Response;

class SuccessResponse
{
    use ResultTrait;

    public function __construct(private readonly EntityData $user)
    {
        $this->setSuccess(true);
        $this->setCode(Response::HTTP_OK);
    }

    public function getEntity(): EntityData
    {
        return $this->user;
    }
}
