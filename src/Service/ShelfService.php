<?php

namespace App\Service;

use App\DTO\ShelfDTO;
use App\Entity\Shelf;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShelfService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ?int | null $page
     * @param int $perPage
     * @return array
     */
    public function getShelves(int | null $page, int $perPage): array
    {
        /**
         * @var ShelfRepository $shelfRepository
         */
        $shelfRepository = $this->entityManager->getRepository(Shelf::class);

        $shelves[] = [];
        if ($page === null) {
            $shelves = $shelfRepository->findBy([], ['id' =>'DESC']);
        } else {
            if ($page < 0)
                return [];

            $shelves = $shelfRepository->getShelves($page, $perPage);
        }

        return $shelves;
    }

    /**
     * @param ShelfDTO $shelfDTO
     * @return Shelf
     */
    public function saveShelf(ShelfDTO $shelfDTO): Shelf
    {
        $shelf = new Shelf();
        $shelf
            ->setTitle($shelfDTO->title)
            ->setDescription($shelfDTO->description);

        $this->entityManager->persist($shelf);
        $this->entityManager->flush();

        return $shelf;
    }

    /**
     * @param ShelfDTO $shelfDTO
     * @param int $shelfId
     * @return null | Shelf
     */
    public function updateShelf(ShelfDTO $shelfDTO, int $shelfId): null | Shelf
    {
        /**
         * @var ShelfRepository $shelfRepository
         */
        $shelfRepository = $this->entityManager->getRepository(Shelf::class);

        /**
         * @var Shelf $shelf
         */

        $shelf = $shelfRepository->find($shelfId);

        if ($shelf === null)
            return null;

        $shelf
            ->setTitle($shelfDTO->title)
            ->setDescription($shelfDTO->description);

        $this->entityManager->flush();

        return $shelf;
    }

    /**
     * @param int $shelfId
     * @return Shelf | null
     */
    public function showShelf(int $shelfId): Shelf | null
    {
        /**
         * @var ShelfRepository $shelfRepository
         */
        $shelfRepository = $this->entityManager->getRepository(Shelf::class);

        $shelf = $shelfRepository->find($shelfId);

        if ($shelf === null)
            return null;
        else
            return $shelf;
    }

    /**
     * @param int $shelfId
     * @return bool
     */
    public function deleteShelf(int $shelfId): bool
    {
        /**
         * @var ShelfRepository $shelfRepository
         */
        $shelfRepository = $this->entityManager->getRepository(Shelf::class);

        /**
         * @var Shelf $shelf
         */
        $shelf = $shelfRepository->find($shelfId);
        if ($shelf === null)
            return false;

        $this->entityManager->remove($shelf);
        $this->entityManager->flush();

        return true;
    }
}
