<?php

namespace App\Service;

use App\Entity\Body;
use App\Entity\User;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Exception\UserExistException;
use App\Exception\UserFieldFromException;
use App\Repository\MealRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MealService
{

    private $mealRepository;
    private $userService;

    public function __construct(UserService $userService, MealRepository $mealRepository)
    {
        $this->mealRepository = $mealRepository;
        $this->userService = $userService;
    }

    public function getAllMealByUser() {
        $user = $this->userService->getCurrentUser();
        if ($user == null) return [];
        $meals = $this->mealRepository->findBy(['user' => $user]);
        $toReturn = [];

        foreach($meals as $meal) {
            $foods =  $meal->getFood()->toArray();
            $foodsDTO = [];
            foreach($foods as $food) {
                array_push($foodsDTO, [
                    'id'=>$food->getId(),
                    'libelle'=>$food->getLibelle(),
                    'calories' => $food->getCalories()
                ]);
            }
    
            array_push($toReturn , [
                'id' => $meal->getId(),
                'name' => $meal->getName(),
                'date' => $meal->getDateTime(),
                'foods' => $foodsDTO
            ]);
    
        }

        return $toReturn;
       
    }

    public function getMeal(DateTime $date = null)
    {

        $mealToReturn = [];

        if (empty($date)) {
            $date = new DateTime();
            $date->format('Y-m-d');
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
        $foods =  $meal->getFood()->toArray();
        $foodsDTO = [];
        foreach($foods as $food) {
            array_push($foodsDTO, [
                'id'=>$food->getId(),
                'libelle'=>$food->getLibelle(),
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
}
