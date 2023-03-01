<?php

namespace App\Controller;

use App\Entity\Body;
use App\Repository\BodyRepository;
use App\Service\UserService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use function PHPUnit\Framework\isEmpty;

class BodyController extends AbstractController
{
    public function index(UserService $userService,BodyRepository $bodyRepository): JsonResponse
    {

        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        $bodies = $bodyRepository->findBy(['user' => $user]);
        $jsonToReturn = [];
        foreach($bodies as $body) {
            array_push($jsonToReturn, [
            "weight" => $body->getWeight(), 
            "objectif_weight" => $body->getObjectifWeight(), 
            "date" => $body->getDateTime()
            ]);
        }

        return $this->json($jsonToReturn);
    }

    public function new(UserService $userService, Request $request, BodyRepository $bodyRepository): JsonResponse
    {
        $body = new Body();
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        $data = json_decode($request->getContent(), true);
        if (!empty($data["objectif_weight"] && !empty($data["weight"]))) {
            $body->setWeight($data["weight"])
            ->setObjectifWeight($data["objectif_weight"])
            ->setDateTime(new DateTime());
            
            $bodyRepository->save($body);
            return $this->json(["status" => 200, "message" => "The Body is created"]);
        }
        
        return $this->json(["status" => 400, "message" => "Error when the data is enter"]);
    }


    public function delete(UserService $userService, Request $request, BodyRepository $bodyRepository): Response
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        $id = $request->attributes->get('id');

        $body = $bodyRepository->findOneBy(['id' => $id, 'user' => $user]);
        if ($body) {
            $bodyRepository->remove($body, true);
            return $this->json(["status" => 200, "message" => "Body is deleted"]);
        }
        return $this->json(["status" => 400, "message" => "Body not found"]);
    }
}
