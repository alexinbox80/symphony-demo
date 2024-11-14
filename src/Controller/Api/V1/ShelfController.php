<?php

namespace App\Controller\Api\V1;

use App\Entity\Shelf;
use App\Form\ShelfType;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
#[Route('/api/v1/shelf')]
final class ShelfController extends AbstractController
{
    #[Route(name: 'app_api_v1_shelf_index', methods: ['GET'])]
    public function index(
        SerializerInterface $serializer,
        ShelfRepository $shelfRepository
    ): JsonResponse
    {

        return (new JsonResponse($serializer->normalize(['data' => $shelfRepository->findAll()]), 200));

        //return ('data' => $shelfRepository->findAll());

        //dd(new JsonResponse([$shelfRepository->findAll(), $status = 200, $headers = [], $context = []]));

//        $data = $serializer->serialize($shelfRepository->findAll(), JsonEncoder::FORMAT);
//        dd($data);
//        dd(new JsonResponse($data, Response::HTTP_OK, [], true));
        //return new JsonResponse($data, Response::HTTP_OK, [], true);

       // return $this->json(['shelves' => $shelfRepository->findAll()], 200);
        //$shelfRepository->findAll();
//        return $this->render('api/v1/shelf/index.html.twig', [
//            'shelves' => $shelfRepository->findAll(),
//        ]);
    }

    #[Route('/new', name: 'app_api_v1_shelf_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shelf = new Shelf();
        $form = $this->createForm(ShelfType::class, $shelf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shelf);
            $entityManager->flush();

            return $this->redirectToRoute('app_api_v1_shelf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api/v1/shelf/new.html.twig', [
            'shelf' => $shelf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_api_v1_shelf_show', methods: ['GET'])]
    public function show(Shelf $shelf): Response
    {
        return $this->render('api/v1/shelf/show.html.twig', [
            'shelf' => $shelf,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_api_v1_shelf_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Shelf $shelf, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShelfType::class, $shelf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_api_v1_shelf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api/v1/shelf/edit.html.twig', [
            'shelf' => $shelf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_api_v1_shelf_delete', methods: ['POST'])]
    public function delete(Request $request, Shelf $shelf, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shelf->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($shelf);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_api_v1_shelf_index', [], Response::HTTP_SEE_OTHER);
    }
}
