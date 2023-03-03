<?php

namespace App\Controller;

use App\Repository\FoodRepository;
use App\Service\foodCache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class FoodController extends AbstractController
{

    /**
     * Get food with libelle
     *
     * @param FoodRepository $foodRepository
     * @param [type] $libelle
     * @param foodCache $foodCache
     * @return JsonResponse
     */
    public function show(FoodRepository $foodRepository, $libelle, foodCache $foodCache): JsonResponse
    {
        if (empty($libelle)) return $this->json(["status" => 404, "messages" => "No parameters libelle found in url"]);

        $foods = $foodCache->get($foodRepository, $libelle);
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
