<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping;

/**
 * @Mapping\Table(name="`user`")
 * @Mapping\Entity(repositoryClass="App\Repository\UserRepository")
 * @Mapping\HasLifecycleCallbacks
 */
class User
{
    use CreatedAtTrait, UpdatedAtTrait;

    /**
     * @Mapping\Id
     * @Mapping\Column(name="id", type="bigint", unique=true)
     * @Mapping\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Mapping\Column(name="login", type="string", length=32, nullable=false, unique=true)
     */
    private $login;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }
}
