<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ProfileDTO
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 4)]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 4)]
        public string $surname,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 4)]
        public string $nickname,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 4)]
        public string $phone,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 4)]
        public string $avatar,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 4)]
        public string $address
    )
    {
        //
    }
}
