<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function getUsers(int $page, int $perPage): array
    {
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->entityManager->getRepository(User::class);

        return $userRepository->getUsers($page, $perPage);
    }

    /**
     * @param UserDTO $userDTO
     * @return int|null
     */
    public function saveUser(UserDTO $userDTO): ?int
    {
        $user = new User();
        $user
            ->setEmail($userDTO->email)
            ->setPassword($userDTO->email)
            ->setIsActive($userDTO->isActive)
            ->setRoles($userDTO->roles);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getId();
    }

    public function updateUser(int $userId, string $login): bool
    {
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->entityManager->getRepository(User::class);

        /**
         * @var User $user
         */

        $user = $userRepository->find($userId);
        if ($user === null)
            return false;

        $user->setLogin($login);
        $this->entityManager->flush();

        return true;
    }

    public function deleteUser(int $userId): bool
    {
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->entityManager->getRepository(User::class);

        /**
         * @var User $user
         */

        $user = $userRepository->find($userId);
        if ($user === null)
            return false;

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return true;
    }
}
