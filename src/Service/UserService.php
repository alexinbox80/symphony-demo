<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Exception\EntityAlreadyExistException;
use App\Exception\EntityNotFoundException;
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
     * @param ?int | null $page
     * @param int $perPage
     * @return array
     * @throws EntityNotFoundException
     */
    public function getUsers(int | null $page, int $perPage): array
    {
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->entityManager->getRepository(User::class);

        $users[] = [];
        if ($page === null) {
            $users = $userRepository->findBy([], ['id' =>'DESC']);
        } else {
            if ($page < 0)
                throw new EntityNotFoundException();

            $users = $userRepository->getUsers($page, $perPage);
        }

        if (empty($users))
            throw new EntityNotFoundException();

        return $users;
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     * @throws EntityAlreadyExistException
     */
    public function saveUser(UserDTO $userDTO): User
    {
        $user = new User();
        $user
            ->setEmail($userDTO->email)
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                $userDTO->password
            ))
            ->setIsActive($userDTO->isActive)
            ->setRoles($userDTO->roles);

        $this->entityManager->persist($user);

        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new EntityAlreadyExistException();
        }

        return $user;
    }

    /**
     * @param UserDTO $userDTO
     * @param int $userId
     * @return User
     * @throws EntityNotFoundException
     */
    public function updateUser(UserDTO $userDTO, int $userId): User
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
            throw new EntityNotFoundException();

        $user
            ->setEmail($userDTO->email)
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                $userDTO->password
            ))
            ->setIsActive($userDTO->isActive)
            ->setRoles($userDTO->roles);

        $this->entityManager->flush();

        return $user;
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
