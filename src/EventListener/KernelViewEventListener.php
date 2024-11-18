<?php

namespace App\EventListener;

use App\Entity\User;
use App\Controller\Api\V1\Output\EntityData;
use App\Controller\Api\V1\Output\SuccessResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class KernelViewEventListener
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $value = $event->getControllerResult();

        if (is_object($value) and $value instanceof User) {
            $entityData = new EntityData($value);
            $successResponse = new SuccessResponse($entityData);
            $event->setResponse($this->getHttpResponse($successResponse));
        }

        if (is_array($value)) {
            $successResponse = [];
            foreach ($value as $item) {
                //dd('Is array');
                $entityData = new EntityData($item);
                $successResponse[] = new SuccessResponse($entityData);
            }

            $event->setResponse($this->getHttpResponse($successResponse));
        }
    }

    private function getHttpResponse(mixed $successResponse): Response
    {
        $responseData = $this->serializer->serialize(
            $successResponse,
            JsonEncoder::FORMAT,
            context: [AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]
        );

        return new Response($responseData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
