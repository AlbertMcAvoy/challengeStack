<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends AbstractController
{
    public function index(ProfileRepository $profileRepository): JsonResponse
    {
        return $this->json(["status" => 404, "message" => "not implemented"]);
    }

    public function new(Request $request, ProfileRepository $profileRepository): JsonResponse
    {
        $profile = new Profile();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileRepository->save($profile, true);

            return $this->json(["status" => 404, "message" => "not implemented"]);
        }

        return $this->json(["status" => 404, "message" => "not implemented"]);
    }

    public function show(Profile $profile): Response
    {
        return $this->json(["status" => 404, "message" => "not implemented"]);
    }

    public function edit(Request $request, Profile $profile, ProfileRepository $profileRepository): JsonResponse
    {
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileRepository->save($profile, true);

            return $this->json(["status" => 404, "message" => "not implemented"]);
        }

        return $this->json(["status" => 404, "message" => "not implemented"]);
    }

    public function delete(Request $request, Profile $profile, ProfileRepository $profileRepository): JsonResponse
    {
        if ($this->isCsrfTokenValid('delete' . $profile->getId(), $request->request->get('_token'))) {
            $profileRepository->remove($profile, true);
        }

        return $this->json(["status" => 404, "message" => "not implemented"]);
    }
}
