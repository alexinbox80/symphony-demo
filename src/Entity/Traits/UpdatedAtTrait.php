<?php

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping;

/*
 * @Mapping\HasLifecycleCallbacks
 */
trait UpdatedAtTrait
{
    /**
     * @var DateTime
     *
     * @Mapping\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected DateTime $updatedAt;

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @Mapping\PreUpdate
     * @Mapping\PrePersist
     */
    public function updateUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }
}
