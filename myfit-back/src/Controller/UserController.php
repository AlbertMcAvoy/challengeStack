<?php

namespace App\Controller;

use App\Repository\UserRepository;
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

    public function delete(UserService $userService, UserRepository $userRepository) {
        $user = $userService->getCurrentUser();
        if ($user == null) {
            return $this->json(["status" => 404, "message" => "Not find user with this token!"]);
        }
        
        $user = $userRepository->findOneBy(["id" => $user->getId()]);

        if($user){
            $userRepository->remove($user, true);
            return $this->json(['status' => 200, 'message' => "User Delete"]);
        }
        return $this->json(['status' => 404, 'message' => "Error on user delete"]);
    }
}
