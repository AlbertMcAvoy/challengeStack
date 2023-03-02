<?php

namespace App\Controller;

use App\Repository\MealRepository;
use App\Service\MealService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MealController extends AbstractController
{
    public function edit(Request $request, UserService $userService, MealService $mealService): Response
    {
        $user = $userService->getCurrentUser();
        $data = json_decode($request->getContent(), true);

        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);

        if (!empty($data['name']) && !empty($data['foods']) && is_array($data['food'])) {
            $mealService->saveMeal($data, $user);
            return $this->json(["status" => 200, "message" => "The Meal is edited"]);
        }
        return $this->json(["status" => 400, "message" => "Error when the data is enter"]);
    }

    public function new(Request $request, UserService $userService, MealService $mealService): Response
    {
        $user = $userService->getCurrentUser();
        $data = json_decode($request->getContent(), true);


        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);

        if (!empty($data['name']) && !empty($data['foods']) && is_array($data['foods'])) {
            $mealService->saveMeal($data, $user);
            return $this->json(["status" => 200, "message" => "The Meal is created"]);
        }

        return $this->json(["status" => 400, "message" => "Error when the data is enter"]);
    }

    public function delete(Request $request, UserService $userService, MealRepository $mealRepository): Response
    {
        $user = $userService->getCurrentUser();
        $id = $request->attributes->get('id');

        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);


        $meal = $mealRepository->findOneBy(['id' => $id, 'user' => $user]);

        if ($meal) {
            $mealRepository->remove($meal, true);
            return $this->json(["status" => 200, "message" => "Meal is deleted"]);
        }
        return $this->json(["status" => 400, "message" => "Meal not found"]);
    }

    public function getMealById(UserService $userService, MealService $mealService, $id): JsonResponse
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        $meal = $this->json($mealService->getMealById($id));
        if (empty($meal)) return $this->json(['status' => 404, 'message' => "No meals found", 'food' => $meal]);
        return $meal;
    }

    public function getAllMealByUser(UserService $userService, MealService $mealService): JsonResponse
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        return $this->json($mealService->getAllMealByUser());
    }

    public function getMealByDate(UserService $userService, MealService $mealService, $date): JsonResponse
    {
        $user = $userService->getCurrentUser();
        if ($user == null) return $this->json(["status" => 404, "message" => "User not found with this token !"]);
        return $this->json($mealService->getMeal($date), 200, [], ['groups' => ['meal_date']]);
    }
}
