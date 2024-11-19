<?php

namespace App\Controller\Api\V1;

use App\DTO\BookDTO;
use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/book')]
class BookController extends AbstractController
{
    /**
     * @param BookService $bookService
     * @param int|null $page
     * @return JsonResponse
     */
    #[Route(
        name: 'app_api_v1_book_index',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function getBookAction(
        BookService $bookService,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $page = null
    ): JsonResponse
    {
        $books = $bookService->getBooks($page, $perPage ?? 20);
        $code = empty($books) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        if (empty($books)) {
            return new JsonResponse([
                'status' => false,
                'message' => 'Books not found!',
                'code' => $code
            ], $code);
        }

        return $this->json($books, $code);
    }

    /**
     * @param BookService $bookService
     * @param BookDTO $bookDTO
     * @return JsonResponse
     */
    #[Route(
        name: 'app_api_v1_book_create',
        methods: ['POST'],
        format: 'json'
    )]
    public function apiCreateProfileAction(
        BookService $bookService,
        #[MapRequestPayload(acceptFormat: 'json')] BookDTO $bookDTO,
    ): JsonResponse
    {
        $bookId = $bookService->saveBook($bookDTO);

        [$data, $code] = $bookId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'id' => $bookId], Response::HTTP_OK];

        return $this->json($data, $code);
    }

    /**
     * @param BookService $bookService
     * @param BookDTO $bookDTO
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}/edit',
        name: 'app_api_v1_book_update',
        requirements: ['id' => '\d+'],
        methods: ['PUT'],
        format: 'json'
    )]
    public function apiUpdateBookAction(
        BookService $bookService,
        #[MapRequestPayload(acceptFormat: 'json')] BookDTO $bookDTO,
        int $id
    ): JsonResponse
    {
        $book = $bookService->updateBook($bookDTO, $id);

        return $this->json([
            'success' => $book,
            'code' => $book ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        ]);
    }

    /**
     * @param BookService $bookService
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}',
        name: 'app_api_v1_book_show',
        requirements: ['id' => '\d+'],
        methods: ['GET'],
        format: 'json'
    )]
    public function apiShowBookAction(
        BookService $bookService,
        int $id,
    ): JsonResponse
    {
        $book = $bookService->showBook($id);
        $code = empty($book) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        if (empty($book)) {
            return new JsonResponse([
                'message' => 'Book not found!',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($book, $code);
    }

    /**
     * @param BookService $bookService
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}',
        name: 'app_api_v1_book_delete',
        requirements: ['id' => '\d+'],
        methods: ['DELETE'],
        format: 'json'
    )]
    public function apiDeleteBookAction(
        BookService $bookService,
        int $id
    ): JsonResponse
    {
        $book = $bookService->deleteBook($id);

        return $this->json([
            'success' => $book,
            'code' => $book ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        ], Response::HTTP_NOT_FOUND);
    }
}
