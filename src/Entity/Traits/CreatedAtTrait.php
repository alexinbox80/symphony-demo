<?php

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Mapping\HasLifecycleCallbacks
 */
trait CreatedAtTrait
{
    /**
     * @var DateTime
     *
     */
    #[ORM\Column(
        name: "created_at",
        type: "datetime",
        nullable: true
    )]
    protected DateTime $createdAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @Mapping\PrePersist
     */
    public function setCreatedAt(): void
    {
       $this->createdAt = new DateTime();
    }
}
