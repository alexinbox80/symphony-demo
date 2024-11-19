<?php

namespace App\Service;

use App\DTO\ProfileDTO;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProfileService
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
    public function getProfiles(int | null $page, int $perPage): array
    {
        /**
         * @var ProfileRepository $profileRepository
         */
        $profileRepository = $this->entityManager->getRepository(Profile::class);

        $profiles[] = [];
        if ($page === null) {
            $profiles = $profileRepository->findBy([], ['id' =>'DESC']);
        } else {
            if ($page < 0)
                return [];

            $profiles = $profileRepository->getProfiles($page, $perPage);
        }

        return $profiles;
    }

    /**
     * @param ProfileDTO $profileDTO
     * @return Profile
     */
    public function saveProfile(ProfileDTO $profileDTO): Profile
    {
        $profile = new Profile();
        $profile
            ->setName($profileDTO->name)
            ->setSurname($profileDTO->surname)
            ->setNickname($profileDTO->nickname)
            ->setPhone($profileDTO->phone)
            ->setAvatar($profileDTO->avatar)
            ->setAddress($profileDTO->address);

        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile;
    }

    /**
     * @param ProfileDTO $profileDTO
     * @param int $profileId
     * @return null | Profile
     */
    public function updateProfile(ProfileDTO $profileDTO, int $profileId): null | Profile
    {
        /**
         * @var ProfileRepository $profileRepository
         */
        $profileRepository = $this->entityManager->getRepository(Profile::class);

        /**
         * @var Profile $profile
         */
        $profile = $profileRepository->find($profileId);

        if ($profile === null)
            return null;

        $profile
            ->setName($profileDTO->name)
            ->setSurname($profileDTO->surname)
            ->setNickname($profileDTO->nickname)
            ->setPhone($profileDTO->phone)
            ->setAvatar($profileDTO->avatar)
            ->setAddress($profileDTO->address);

        $this->entityManager->flush();

        return $profile;
    }

    /**
     * @param int $profileId
     * @return Profile | null
     */
    public function showProfile(int $profileId): Profile | null
    {
        /**
         * @var ProfileRepository $profileRepository
         */
        $profileRepository = $this->entityManager->getRepository(Profile::class);

        $profile = $profileRepository->find($profileId);

        if ($profile === null)
            return null;
        else
            return $profile;
    }

    /**
     * @param int $profileId
     * @return bool
     */
    public function deleteProfile(int $profileId): bool
    {
        /**
         * @var ProfileRepository $profileRepository
         */
        $profileRepository = $this->entityManager->getRepository(Profile::class);

        /**
         * @var Profile $profile
         */
        $profile = $profileRepository->find($profileId);
        if ($profile === null)
            return false;

        $this->entityManager->remove($profile);
        $this->entityManager->flush();

        return true;
    }
}
