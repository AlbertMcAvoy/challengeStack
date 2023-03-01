<?php

namespace App\Controller;

use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FoodController extends AbstractController
{

    public function show(FoodRepository $foodRepository, $libelle): JsonResponse
    {
        if (empty($libelle)) return $this->json(["status" => 404, "messages" => "No parameters libelle found in url"]);

        $foods = $foodRepository->findAllByLibelle($libelle);
        $jsonToResponse = [];

        foreach ($foods as $food) {
            $jsonToResponse[] = [
                "id" => $food->getId(),
                "libelle" => $food->getLibelle(),
                "calories" => $food->getCalories()
            ];
        }
        return $this->json(["status" => 200, "foods" => $jsonToResponse]);
    }
}
