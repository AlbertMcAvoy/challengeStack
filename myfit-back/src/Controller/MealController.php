<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\Meal;
use App\Form\MealType;
use App\Repository\FoodRepository;
use App\Repository\MealRepository;
use App\Service\MealService;
use App\Service\UserService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MealController extends AbstractController
{
    public function edit(Request $request, UserService $userService, MealRepository $mealRepository, FoodRepository $foodRepository): Response
    {
        $meal = !empty($request->attributes->get('id')) ? new Meal($request->attributes->get('id')) : new Meal();
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        $data = json_decode($request->getContent(), true);
        if (!empty($data['name']) && !empty($data['food']) && is_array($data['food'])) {
            foreach($data['food'] as $foodId) {
                $food = $foodRepository->find($foodId);
                if ($food) {
                    $meal->addFood($food);
                }
            }

            $meal->setName($data['name'])
                ->setUser($user)
                ->setDateTime(new DateTime());

            $mealRepository->save($meal, true);
            return $this->json(["status" => 200, "message" => "The Meal is created"]);
        }

        return $this->json(["status" => 400, "message" => "Error when the data is enter"]);
    }

    public function delete(Request $request, UserService $userService, Meal $meal, MealRepository $mealRepository): Response
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        $id = $request->attributes->get('id');

        $meal = $mealRepository->findOneBy(['id' => $id, 'user' => $user]);
        if ($meal) {
            $mealRepository->remove($meal, true);
            return $this->json(["status" => 200, "message" => "Meal is deleted"]);
        }
        return $this->json(["status" => 400, "message" => "Meal not found"]);
    }

    public function getMealById(Request $request, UserService $userService, MealService $mealService): JsonResponse
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        return $this->json($mealService->getMealById($request->attributes->get('id')));
    }

    public function getAllMealByUser(UserService $userService, MealService $mealService): JsonResponse
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        return $this->json($mealService->getAllMealByUser());
    }

    public function getMealByDate(Request $request, UserService $userService, MealService $mealService): JsonResponse
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        return $this->json($mealService->getMeal($request->attributes->get('date')));
    }
}
