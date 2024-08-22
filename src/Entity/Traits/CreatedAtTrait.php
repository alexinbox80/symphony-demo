<?php

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints\DateTime;

/*
 * @Mapping\HasLifecycleCallbacks
 */
trait CreatedAtTrait
{
    /**
     * @var DateTime
     *
     * @Mapping\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @Mapping\PrePersist
     */
    public function setCreatedAt(): void
    {
       $this->creatidAt = new DateTime();
    }
}
