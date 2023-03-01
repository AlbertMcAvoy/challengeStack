<?php

namespace App\Service;

use App\Entity\Meal;
use App\Entity\User;
use App\Repository\FoodRepository;
use DateTime;
use Date;
use App\Repository\MealRepository;

class MealService
{

    private $mealRepository;
    private $userService;
    private $foodRepository;

    public function __construct(UserService $userService, MealRepository $mealRepository, FoodRepository $foodRepository)
    {
        $this->mealRepository = $mealRepository;
        $this->userService = $userService;
        $this->mealRepository = $mealRepository;
    }

    public function getAllMealByUser()
    {
        $user = $this->userService->getCurrentUser();
        if ($user == null) {
            return array();
        }

        $meals = $this->mealRepository->findBy(['user' => $user]);
        $toReturn = array();

        foreach ($meals as $meal) {
            if (!empty($meal->getFood())) {
                $foodsDTO = array_map(function ($food) {
                    return [
                        'id' => $food->getId(),
                        'libelle' => $food->getLibelle(),
                        'calories' => $food->getCalories()
                    ];
                }, $meal->getFood()->toArray());
            }


            array_push($toReturn, [
                'id' => $meal->getId(),
                'name' => $meal->getName(),
                'date' => $meal->getDateTime(),
                'foods' => $foodsDTO
            ]);
        }

        return $toReturn;
    }

    public function getMeal(String $input = null)
    {
        $mealToReturn = [];
        $date = date('Y-m-d', strtotime($input));
        if (empty($input)) {
            $date = date('Y-m-d');
        }
        $user = $this->userService->getCurrentUser();

        $mealList = $this->mealRepository->findByDates($date, $user);
        foreach ($mealList as $meal) {
            array_push($mealToReturn, ['id' => $meal->getId(), 'name' => $meal->getName(), 'date' => $meal->getDateTime()]);
        }
        return $mealToReturn;
    }

    public function getMealById($id)
    {
        if (empty($id)) return [];
        $user = $this->userService->getCurrentUser();
        $meal = $this->mealRepository->findOneBy(['id' => $id, 'user' => $user]);
        if (!empty($meal)) {
            $foods =  $meal->getFood()->toArray();
            $foodsDTO = [];
            foreach ($foods as $food) {
                array_push($foodsDTO, [
                    'id' => $food->getId(),
                    'libelle' => $food->getLibelle(),
                    'calories' => $food->getCalories()
                ]);
            }


            $toReturn = [
                'id' => $meal->getId(),
                'name' => $meal->getName(),
                'date' => $meal->getDateTime(),
                'foods' => $foodsDTO
            ];

            return $toReturn;
        }
        return [];
    }

    public function saveMeal($data, Meal $meal, User $user)
    {
        foreach ($data['food'] as $foodId) {
            $food = $this->foodRepository->find($foodId);
            if ($food) {
                $meal->addFood($food);
            }
        }

        $meal->setName($data['name'])
            ->setUser($user)
            ->setDateTime(new DateTime());

        $this->mealRepository->save($meal, true);
    }
}
