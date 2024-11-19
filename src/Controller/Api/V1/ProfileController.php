<?php

namespace App\Controller\Api\V1;

use App\DTO\ProfileDTO;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/profile')]
class ProfileController extends AbstractController
{
    /**
     * @param ProfileService $profileService
     * @param int|null $page
     * @return JsonResponse
     */
    #[Route(
        name: 'app_api_v1_profile_index',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function getProfilesAction(
        ProfileService $profileService,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $page = null
    ): JsonResponse
    {
        $profiles = $profileService->getProfiles($page, $perPage ?? 20);
        $code = empty($profiles) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        if (empty($profiles)) {
            return new JsonResponse([
                'status' => false,
                'message' => 'Profiles not found!',
                'code' => $code
            ], $code);
        }

        //return $this->json($profiles, $code, context: [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
        return $this->json($profiles, $code);
    }

    /**
     * @param ProfileService $profileService
     * @param ProfileDTO $profileDTO
     * @return JsonResponse
     */
    #[Route(
        name: 'app_api_v1_profile_create',
        methods: ['POST'],
        format: 'json'
    )]
    public function apiCreateProfileAction(
        ProfileService $profileService,
        #[MapRequestPayload(acceptFormat: 'json')] ProfileDTO $profileDTO,
    ): JsonResponse
    {
        $profileId = $profileService->saveProfile($profileDTO);

        [$data, $code] = $profileId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'id' => $profileId], Response::HTTP_OK];

        return $this->json($data, $code);
    }

    /**
     * @param ProfileService $profileService
     * @param ProfileDTO $profileDTO
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}/edit',
        name: 'app_api_v1_profile_update',
        requirements: ['id' => '\d+'],
        methods: ['PUT'],
        format: 'json'
    )]
    public function apiUpdateUserAction(
        ProfileService $profileService,
        #[MapRequestPayload(acceptFormat: 'json')] ProfileDTO $profileDTO,
        int $id
    ): JsonResponse
    {
        $profile = $profileService->updateProfile($profileDTO, $id);

        return $this->json([
            'success' => $profile,
            'code' => $profile ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        ]);
    }

    /**
     * @param ProfileService $profileService
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}',
        name: 'app_api_v1_profile_show',
        requirements: ['id' => '\d+'],
        methods: ['GET'],
        format: 'json'
    )]
    public function apiShowProfileAction(
        ProfileService $profileService,
        int $id,
    ): JsonResponse
    {
        $profile = $profileService->showProfile($id);
        $code = empty($profile) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        if (empty($profile)) {
            return new JsonResponse([
                'message' => 'Profile not found!',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($profile, $code);
    }

    /**
     * @param ProfileService $profileService
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}',
        name: 'app_api_v1_profile_delete',
        requirements: ['id' => '\d+'],
        methods: ['DELETE'],
        format: 'json'
    )]
    public function apiDeleteProfileAction(
        ProfileService $profileService,
        int $id
    ): JsonResponse
    {
        $profile = $profileService->deleteProfile($id);

        return $this->json([
            'success' => $profile,
            'code' => $profile ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        ], Response::HTTP_NOT_FOUND);
    }
}
