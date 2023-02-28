<?php

namespace App\Controller;

use App\Entity\Body;
use App\Form\BodyType;
use App\Repository\BodyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BodyController extends AbstractController
{
    public function index(BodyRepository $bodyRepository): Response
    {
        return $this->render('body/index.html.twig', [
            'bodies' => $bodyRepository->findAll(),
        ]);
    }

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

    public function show(Body $body): Response
    {
        return $this->render('body/show.html.twig', [
            'body' => $body,
        ]);
    }

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

    public function delete(Request $request, Body $body, BodyRepository $bodyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$body->getId(), $request->request->get('_token'))) {
            $bodyRepository->remove($body, true);
        }

        return $this->redirectToRoute('app_body_index', [], Response::HTTP_SEE_OTHER);
    }
}
