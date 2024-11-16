<?php

namespace App\Controller\Api\V1;

use App\Service\UserService;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class UserController extends AbstractController
{
//    /**
//     * @var UserService
//     */
//    private UserService $userService;

//    public function __construct(UserService $userService)
//    {
//        $this->userService = $userService;
//    }

    #[Route('/api/v1/user',
        name: 'app_api_v1_user_index ',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function getUsersAction(
        UserService $userService,
        #[MapQueryParameter] ?int $page = null
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

        return ($this->json($users, $code, context: [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]));
    }

    /**
     * @Annotation\Post("")
     * @Annotation\RequestParam(name="login", requirements="\w{0,32}")
     *
     * @param string $login
     * @return View
     */
    public function saveUserAction(string $login): View
    {
        $userId = $this->userService->saveUser($login);
        [$data, $code] = $userId === null ?
            [['success' => false], 400] :
            [['success' => true, 'userId' => $userId], 200];

        return View::create($data, $code);
    }

    /**
     * @Annotation\Patch("")
     * @Annotation\QueryParam(name="userId", requirements="\d+", nullable=false)
     * @Annotation\QueryParam(name="login", requirements="\w{0, 32}")
     *
     * @param int $userId
     * @return View
     */
    public function updateUserAction(int $userId, string $login): View
    {
        $result = $this->userService->updateUser($userId, $login);

        return View::create([
            'success' => $result
        ],
            $result ? 200 : 404
        );
    }

    /**
     * @Annotation\Delete("")
     * @Annotation\QueryParam(name="userId", requirements="\d+", nullable=false)
     *
     * @param int $userId
     * @return View
     */
    public function deleteUserAction(int $userId): View
    {
        $result = $this->userService->deleteUser($userId);

        return View::create([
            'success' => $result
        ],
            $result ? 200 : 404
        );
    }
}
