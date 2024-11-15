<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
trait UpdatedAtTrait
{
    #[ORM\Column(
        name: 'updated_at',
        type: 'datetime',
        nullable: true
    )]
    protected \DateTime $updatedAt;

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
