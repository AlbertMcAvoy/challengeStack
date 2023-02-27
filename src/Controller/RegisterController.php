<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController
{
    private $user_service;
 
    public function __construct(UserService $user_service) {
        $this->user_service = $user_service;
    }

    public function register(Request $request): JsonResponse
    { 
        $data = json_decode($request->getContent(), true);
        try {
            $this->user_service->register($data);
            $jsonResponse["status"] = 200;
            $jsonResponse["message"] = "the User has been registered successfully";
        } catch (\Exception $e) {
            $jsonResponse["status"] = 500;
            $jsonResponse["message"] = $e->getMessage();
        }

        return $this->json($jsonResponse);
    }
}

?>



