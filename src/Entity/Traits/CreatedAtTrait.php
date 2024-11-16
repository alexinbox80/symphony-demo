<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
trait CreatedAtTrait
{
    #[ORM\Column(
        name: 'created_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected \DateTime $createdAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
       $this->createdAt = new \DateTime();
    }
}
