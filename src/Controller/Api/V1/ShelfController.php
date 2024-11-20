<?php

namespace App\Controller\Api\V1;

use App\DTO\ShelfDTO;
use App\Service\ShelfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/shelf')]
class ShelfController extends AbstractController
{
    /**
     * @param ShelfService $shelfService
     * @param int|null $page
     * @return JsonResponse
     */
    #[Route(
        name: 'app_api_v1_shelf_index',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function getShelvesAction(
        ShelfService $shelfService,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $page = null
    ): JsonResponse
    {
        $shelves = $shelfService->getShelves($page, $perPage ?? 20);
        $code = empty($shelves) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        if (empty($shelves)) {
            return new JsonResponse([
                'status' => false,
                'message' => 'Shelves not found!',
                'code' => $code
            ], $code);
        }

        return $this->json($shelves, $code);
    }

    /**
     * @param ShelfService $shelfService
     * @param ShelfDTO $shelfDTO
     * @return JsonResponse
     */
    #[Route(
        name: 'app_api_v1_shelf_create',
        methods: ['POST'],
        format: 'json'
    )]
    public function apiCreateShelfAction(
        ShelfService $shelfService,
        #[MapRequestPayload(acceptFormat: 'json')] ShelfDTO $shelfDTO,
    ): JsonResponse
    {
        $shelfId = $shelfService->saveShelf($shelfDTO);

        [$data, $code] = $shelfId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'id' => $shelfId], Response::HTTP_OK];

        return $this->json($data, $code);
    }

    /**
     * @param ShelfService $shelfService
     * @param ShelfDTO $shelfDTO
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}/edit',
        name: 'app_api_v1_shelf_update',
        requirements: ['id' => '\d+'],
        methods: ['PUT'],
        format: 'json'
    )]
    public function apiUpdateShelfAction(
        ShelfService $shelfService,
        #[MapRequestPayload(acceptFormat: 'json')] ShelfDTO $shelfDTO,
        int $id
    ): JsonResponse
    {
        $shelf = $shelfService->updateShelf($shelfDTO, $id);

        return $this->json([
            'success' => $shelf,
            'code' => $shelf ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        ]);
    }

    /**
     * @param ShelfService $shelfService
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}',
        name: 'app_api_v1_shelf_show',
        requirements: ['id' => '\d+'],
        methods: ['GET'],
        format: 'json'
    )]
    public function apiShowShelfAction(
        ShelfService $shelfService,
        int $id,
    ): JsonResponse
    {
        $shelf = $shelfService->showShelf($id);
        $code = empty($shelf) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        if (empty($shelf)) {
            return new JsonResponse([
                'message' => 'Shelf not found!',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($shelf, $code);
    }

    /**
     * @param ShelfService $shelfService
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}',
        name: 'app_api_v1_shelf_delete',
        requirements: ['id' => '\d+'],
        methods: ['DELETE'],
        format: 'json'
    )]
    public function apiDeleteShelfAction(
        ShelfService $shelfService,
        int $id
    ): JsonResponse
    {
        $shelf = $shelfService->deleteShelf($id);

        return $this->json([
            'success' => $shelf,
            'code' => $shelf ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        ], Response::HTTP_NOT_FOUND);
    }
}
