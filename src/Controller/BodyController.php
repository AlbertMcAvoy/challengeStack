<?php

namespace App\Controller;

use App\Entity\Body;
use App\Form\BodyType;
use App\Repository\BodyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/body')]
class BodyController extends AbstractController
{
    #[Route('/', name: 'app_body_index', methods: ['GET'])]
    public function index(BodyRepository $bodyRepository): Response
    {
        return $this->render('body/index.html.twig', [
            'bodies' => $bodyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_body_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BodyRepository $bodyRepository): Response
    {
        $body = new Body();
        $form = $this->createForm(BodyType::class, $body);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bodyRepository->save($body, true);

            return $this->redirectToRoute('app_body_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('body/new.html.twig', [
            'body' => $body,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_body_show', methods: ['GET'])]
    public function show(Body $body): Response
    {
        return $this->render('body/show.html.twig', [
            'body' => $body,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_body_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Body $body, BodyRepository $bodyRepository): Response
    {
        $form = $this->createForm(BodyType::class, $body);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bodyRepository->save($body, true);

            return $this->redirectToRoute('app_body_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('body/edit.html.twig', [
            'body' => $body,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_body_delete', methods: ['POST'])]
    public function delete(Request $request, Body $body, BodyRepository $bodyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$body->getId(), $request->request->get('_token'))) {
            $bodyRepository->remove($body, true);
        }

        return $this->redirectToRoute('app_body_index', [], Response::HTTP_SEE_OTHER);
    }
}
