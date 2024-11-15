<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
trait CreatedAtTrait
{
    #[ORM\Column(
        name: 'created_at',
        type: 'datetime',
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
