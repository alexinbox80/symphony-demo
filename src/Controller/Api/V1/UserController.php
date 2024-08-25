<?php

namespace App\Controller\Api\V1;

use App\Service\UserService;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;

/**
 * @Annotations\Route("/api/v1/user")
 */
class UserController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Annotation\Get("")
     * @Annotation\QueryParam(name="page", requirements="\d+", nullable=true)
     * @Annotation\QueryParam(name="perPage", requirements="\d+", nullable=true)
     *
     * @param int|null $page
     * @param int|null $perPage
     * @return View
     */
    public function getUsersAction(?int $page = null, ?int $perPage = null): View
    {
        $users = $this->userService->getUsers($page ?? 0, $perPage ?? 20);
        $code = empty($users) ? 204 : 200;

        return View::create([
            'users' => $users,
            $code
        ]);
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