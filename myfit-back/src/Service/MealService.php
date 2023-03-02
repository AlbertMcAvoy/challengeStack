<?php

namespace App\Service;

use App\Entity\Meal;
use App\Repository\FoodRepository;
use DateTime;
use App\Repository\MealRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class MealService
{

    private MealRepository $mealRepository;
    private UserService $userService;
    private FoodRepository $foodRepository;
    private EncryptService $encryptService;

    public function __construct(UserService $userService, MealRepository $mealRepository, FoodRepository $foodRepository, EncryptService $encryptService)
    {
        $this->foodRepository = $foodRepository;
        $this->userService = $userService;
        $this->mealRepository = $mealRepository;
        $this->encryptService = $encryptService;
    }

    public function getAllMealByUser()
    {
        $user = $this->userService->getCurrentUser();

        if ($user == null) {
            return [];
        }

        $meals = $this->mealRepository->findBy(['user' => $user]);
        $toReturn = [];
        $foodsDTO = [];

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

            $toReturn[] = [
                'id' => $meal->getId(),
                'name' => $meal->getName(),
                'date' => $meal->getDateTime(),
                'foods' => $foodsDTO
            ];
        }

        return $toReturn;
    }

    public function getMeal(String $input = null)
    {
        $mealToReturn = [];
        $date = date('Y-m-d', strtotime($input));
        $user = $this->userService->getCurrentUser();

        if (empty($input)) {
            $date = date('Y-m-d');
        }

        $mealList = $this->mealRepository->findByDates($date, $user);

        foreach ($mealList as $meal) {
            $mealToReturn[] = [
                'id' => $meal->getId(),
                'name' => $meal->getName(),
                'date' => $meal->getDateTime(),
                'foods' => $meal->getFood()
            ];
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
                $foodsDTO[] = [
                    'id' => $food->getId(),
                    'libelle' => $food->getLibelle(),
                    'calories' => $food->getCalories()
                ];
            }


            return [
                'id' => $meal->getId(),
                'name' => $meal->getName(),
                'date' => $meal->getDateTime(),
                'foods' => $foodsDTO
            ];
        }

        return [];
    }

    public function saveMeal($data, UserInterface $user)
    {
        $meal = new Meal();

        foreach ($data['foods'] as $foodId) {
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
