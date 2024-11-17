<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
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
            ->setPassword($userDTO->password)
            ->setIsActive($userDTO->isActive)
            ->setRoles($userDTO->roles);

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getId();
    }

    /**
     * @param UserDTO $userDTO
     * @param int $userId
     * @return bool
     */
    public function updateUser(UserDTO $userDTO, int $userId): bool
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

        $user
            ->setEmail($userDTO->email)
            ->setPassword($userDTO->password)
            ->setIsActive($userDTO->isActive)
            ->setRoles($userDTO->roles);

        $this->entityManager->flush();

        return true;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function showUser(int $userId): User|null
    {
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->entityManager->getRepository(User::class);

        $user = $userRepository->find($userId);
        if ($user === null)
            return null;
        else
            return $user;
    }

    /**
     * @param int $userId
     * @return bool
     */
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
