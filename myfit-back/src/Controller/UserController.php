<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{

    public function get(UserService $userService): JsonResponse
    {

        $user = $userService->getCurrentUser();

        if ($user == null) {
            return $this->json(["status" => 404, "message" => "Not find user with this token!"]);
        }

        $body = $user->getBodies()->last();

        return $this->json([
            "id" => $user->getId(),
            "firstname" => $user->getFirstname(),
            "lastname" => $user->getLastname(),
            "gender" => $user->getGender(),
            "age" => $user->getAge(),
            "phone" => $user->getPhone(),
            "subscription_date" => $user->getSubscriptionDate(),
            "objectif_weight" => $user->getObjectifWeight(),
            "height" => $user->getHeight(),
            "weight" => !empty($body) ? $body->getWeight() ?? null : null
        ]);
    }
}
