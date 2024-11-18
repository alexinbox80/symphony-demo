<?php

namespace App\Controller\Api\V1\Output;

use App\Entity\User;

readonly class EntityData
{
    public function __construct(
        private User $user,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
