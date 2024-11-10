<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`users`")]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use CreatedAtTrait, UpdatedAtTrait;

    /** One User has One Profile. */
    #[ORM\OneToOne(targetEntity: Profile::class, mappedBy: 'profile')]
    private Profile|null $profile = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(
        length: 128,
        unique: true,
        nullable: false
    )]
    private ?string $email;

    #[ORM\Column(
        type: Types::STRING,
    )]
    private ?string $password = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        nullable: true,
    )]
    private \DateTime|null $email_verified_at = null;

//    #[ORM\Column]
//    private array $roles = [];


    public function __construct()
    {
   //     $this->profile = new ArrayCollection();
    }

    /**
     * @return Profile
     */
    public function getProfile(): Profile
    {
        return $this->profile;
    }
    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
//        $roles = $this->roles;
//        // guarantee every user at least has ROLE_USER
//        $roles[] = 'ROLE_USER';
//        return array_unique($roles);
        return [];
    }
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return void
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return \DateTime|null
     */
    public function getEmailVerifiedAt(): ?\DateTime
    {
        return $this->email_verified_at;
    }

    /**
     * @param \DateTime|null $email_verified_at
     * @return void
     */
    public function setEmailVerifiedAt(?\DateTime $email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addProfile(Profile $profile): self
    {
//        if (!$this->profile->contains($profile)) {
//            $this->profile[] = $profile;
//            $profile->setUser($this);
//        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
//        if ($this->products->contains($product)) {
//            $this->products->removeElement($product);
//            // установить владеющую сторону как null (если ещё не изменена)
//            if ($product->getCategory() === $this) {
//                $product->setCategory(null);
//            }
//        }

        return $this;
    }
}
