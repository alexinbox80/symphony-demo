<?php

namespace App\Service;

use App\DTO\BookDTO;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookService
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
    public function getBooks(int | null $page, int $perPage): array
    {
        /**
         * @var BookRepository $bookRepository
         */
        $bookRepository = $this->entityManager->getRepository(Book::class);

        $books[] = [];
        if ($page === null) {
            $books = $bookRepository->findBy([], ['id' =>'DESC']);
        } else {
            if ($page < 0)
                return [];

            $books = $bookRepository->getBooks($page, $perPage);
        }

        return $books;
    }

    /**
     * @param BookDTO $bookDTO
     * @return Book
     */
    public function saveBook(BookDTO $bookDTO): Book
    {
        $book = new Book();
        $book
            ->setTitle($bookDTO->title)
            ->setDescription($bookDTO->description);

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    /**
     * @param BookDTO $bookDTO
     * @param int $bookId
     * @return null | Book
     */
    public function updateBook(BookDTO $bookDTO, int $bookId): null | Book
    {
        /**
         * @var BookRepository $bookRepository
         */
        $bookRepository = $this->entityManager->getRepository(Book::class);

        /**
         * @var Book $book
         */

        $book = $bookRepository->find($bookId);

        if ($book === null)
            return null;

        $book
            ->setTitle($bookDTO->title)
            ->setDescription($bookDTO->description);

        $this->entityManager->flush();

        return $book;
    }

    /**
     * @param int $bookId
     * @return Book | null
     */
    public function showBook(int $bookId): Book|null
    {
        /**
         * @var BookRepository $bookRepository
         */
        $bookRepository = $this->entityManager->getRepository(Book::class);

        $book = $bookRepository->find($bookId);

        if ($book === null)
            return null;
        else
            return $book;
    }

    /**
     * @param int $bookId
     * @return bool
     */
    public function deleteBook(int $bookId): bool
    {
        /**
         * @var BookRepository $bookRepository
         */
        $bookRepository = $this->entityManager->getRepository(Book::class);

        /**
         * @var Book $book
         */
        $book = $bookRepository->find($bookId);
        if ($book === null)
            return false;

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return true;
    }
}
