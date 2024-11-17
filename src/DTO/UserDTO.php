<?php

namespace App\DTO;

use App\ValueObject\UserRoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDTO
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Email]
//        #[Assert\Unique(
//            message: 'This email is already in use on that system.',
//            fields: 'email',
//        )]
        //#[Assert\Unique(fields: ['email'])]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 8)]
        public string $password,

        #[Assert\Choice(callback: [UserRoleEnum::class, 'values'], multiple: true)]
        public ?array $roles,

        #[Assert\Type('bool')]
        public ?bool  $isActive
    )
    {
        //
    }
}