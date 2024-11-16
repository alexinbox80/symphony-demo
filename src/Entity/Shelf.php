<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\ShelfRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: ShelfRepository::class)]
#[ORM\Table(name: "`shelves`")]
#[ORM\HasLifecycleCallbacks]
class Shelf
{
    use CreatedAtTrait, UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    //#[Ignore]
    #[ORM\OneToOne(mappedBy: 'shelf', cascade: ['persist', 'remove'])]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        // unset the owning side of the relation if necessary
        if ($book === null && $this->book !== null) {
            $this->book->setShelf(null);
        }

        // set the owning side of the relation if necessary
        if ($book !== null && $book->getShelf() !== $this) {
            $book->setShelf($this);
        }

        $this->book = $book;

        return $this;
    }
}
