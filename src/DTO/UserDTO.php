<?php

namespace App\DTO;

use App\ValueObject\UserRoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDTO
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Email]
        //#[Assert\Unique(fields: ['email'])]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(8)]
        public string $password,

        #[Assert\Choice(callback: [UserRoleEnum::class, 'values'] , multiple: true)]
        public ?array $roles,

        #[Assert\Type('bool')]
        public ?bool $isActive
    )
    {
        //
    }
}