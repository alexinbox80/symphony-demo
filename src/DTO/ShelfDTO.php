<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ShelfDTO
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 8)]
        public string $title,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 8)]
        public string $description
    )
    {
        //
    }
}
