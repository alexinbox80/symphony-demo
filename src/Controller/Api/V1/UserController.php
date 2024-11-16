<?php

namespace App\Controller\Api\V1;

use App\DTO\UserDTO;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/v1/user')]
class UserController extends AbstractController
{
    #[Route(
        name: 'app_api_v1_user_index',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function getUsersAction(
        UserService $userService,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $page = null
        //Request $request
//        ?int $page = null,
//        ?int $perPage = null
    ): JsonResponse
    {
        //$page = $request->query->getInt('page', 0);
        //is_numeric
        $users = $userService->getUsers($page ?? 0, $perPage ?? 20);
        $code = empty($users) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        if (empty($users)) {
            return new JsonResponse([
                'msg' => 'Users not found!',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        //return new JsonResponse($serializer->serialize($users, 'json'), $status = $code, $headers = []);
        //return $this->json($serializer->serialize($users, 'json'));
//        return $this->json([
//            'users' => $serializer->serialize($users, 'json'),
//            'code' => $code
//        ], $code);

        return $this->json($users, $code, context: [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
    }

    #[Route(
        name: 'app_api_v1_user_create',
        methods: ['POST'],
        format: 'json'
    )]
    public function apiCreateUserAction(
        UserService $userService,
        #[MapRequestPayload(acceptFormat: 'json')] UserDTO $userDTO,
    ): JsonResponse
    {
        $userId = $userService->saveUser($userDTO);

        [$data, $code] = $userId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'userId' => $userId], Response::HTTP_OK];

        return $this->json($data, $code);
    }

    #[Route('/{id}/edit',
        name: 'app_api_v1_user_update',
        methods: ['PUT'],
        format: 'json'
    )]
    public function apiUpdateUserAction(
        UserService $userService,
        int $userId, string $login
    ): JsonResponse
    {
        $result = $userService->updateUser($userId, $login);

//        return View::create([
//            'success' => $result
//        ],
//            $result ? 200 : 404
//        );
        return $this->json([]);
    }

    #[Route('/{id}',
        name: 'app_api_v1_user_show',
        methods: ['GET'],
        format: 'json'
    )]
    public function apiShowUserAction(
        UserService $userService,
        int $userId, string $login
    ): JsonResponse
    {
        $result = $userService->updateUser($userId, $login);

//        return View::create([
//            'success' => $result
//        ],
//            $result ? 200 : 404
//        );
        return $this->json([]);
    }

    #[Route('/{id}',
        name: 'app_api_v1_user_delete',
        methods: ['DELETE'],
        format: 'json'
    )]
    public function apiDeleteUserAction(
        UserService $userService,
        int $userId
    ): JsonResponse
    {
        $result = $userService->deleteUser($userId);

//        return View::create([
//            'success' => $result
//        ],
//            $result ? 200 : 404
//        );
        return $this->json([]);
    }
}
