<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\DTO\UserDTO;
use App\Exception\EntityAlreadyExistException;
use App\Exception\EntityNotFoundException;
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
    /**
     * @param UserService $userService
     * @param int|null $page
     * @return array
     * @throws EntityNotFoundException
     */
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
    ): array //JsonResponse
    {
        //$page = $request->query->getInt('page', 0);
        //is_numeric

        return $userService->getUsers($page, $perPage ?? 20);
//        $code = empty($users) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

//        if (empty($users)) {
//            return new JsonResponse([
//                'status' => false,
//                'message' => 'Users not found!',
//                'code' => $code
//            ], $code);
//        }

        //return new JsonResponse($serializer->serialize($users, 'json'), $status = $code, $headers = []);
        //return $this->json($serializer->serialize($users, 'json'));
//        return $this->json([
//            'users' => $serializer->serialize($users, 'json'),
//            'code' => $code
//        ], $code);

        //return $this->json($users, $code, context: [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
    }

    /**
     * @throws EntityAlreadyExistException
     */
    #[Route(
        name: 'app_api_v1_user_create',
        methods: ['POST'],
        format: 'json'
    )]
    public function apiCreateUserAction(
        UserService $userService,
        #[MapRequestPayload(acceptFormat: 'json')] UserDTO $userDTO,
    ): User//JsonResponse
    {
        //$userId =
        return $userService->saveUser($userDTO);

//        [$data, $code] = $userId === null ?
//            [['success' => false], Response::HTTP_BAD_REQUEST] :
//            [['success' => true, 'userId' => $userId], Response::HTTP_OK];

        //return $this->json($data, $code);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/{id}/edit',
        name: 'app_api_v1_user_update',
        requirements: ['id' => '\d+'],
        methods: ['PUT'],
        format: 'json'
    )]
    public function apiUpdateUserAction(
        UserService $userService,
        #[MapRequestPayload(acceptFormat: 'json')] UserDTO $userDTO,
        int $id
    ): User // JsonResponse
    {
        return $userService->updateUser($userDTO, $id);

//        return $this->json([
//            'success' => $result,
//            'code' => $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
//        ]);
    }

    #[Route('/{id}',
        name: 'app_api_v1_user_show',
        requirements: ['id' => '\d+'],
        methods: ['GET'],
        format: 'json'
    )]
    public function apiShowUserAction(
        UserService $userService,
        int $id,
    ): JsonResponse
    {
        $user = $userService->showUser($id);
        $code = empty($user) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        if (empty($user)) {
            return new JsonResponse([
                'message' => 'Users not found!',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user, $code, context: [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
    }

    #[Route('/{id}',
        name: 'app_api_v1_user_delete',
        requirements: ['id' => '\d+'],
        methods: ['DELETE'],
        format: 'json'
    )]
    public function apiDeleteUserAction(
        UserService $userService,
        int $id
    ): JsonResponse
    {
        $result = $userService->deleteUser($id);

        return $this->json([
            'success' => $result,
            'code' => $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        ], Response::HTTP_NOT_FOUND);
    }
}
