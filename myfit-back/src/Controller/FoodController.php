<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\FoodType;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FoodController extends AbstractController
{

    public function show(Request $request, FoodRepository $foodRepository): JsonResponse
    {
        $libelle = $request->attributes->get('libelle');
        
        $foods = $foodRepository->findAllByLibelle($libelle);
        $jsonToResponse = [];
        foreach ($foods as $food) {
            array_push($jsonToResponse, [
                "id" => $food->getId(),
                "libelle" => $food->getLibelle(),
                "calories" => $food->getCalories()
            ]);
        }

        return $this->json(["status" => 200, "foods" => $jsonToResponse]);
    }
}
