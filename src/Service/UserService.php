<?php 
namespace App\Service;

use App\Entity\User;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserService {

    private $userPasswordHasher;
    private $entityManager;


    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
    }

    public function register(Array $data) {
        $user = new User();
        
        if (!empty($data['firstname']) && !empty($data['lastname']) && !empty($data['email']) && !empty($data['password'])) {
            $user->setFirstName($data['firstname'])
            ->setLastName($data['lastname'])
            ->setEmail($data['email'])
            ->setSubscriptionDate(new DateTime());

            $user->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']));
            
        }

       try {

            $this->entityManager->persist($user);
            $this->entityManager->flush();
       } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
       }

    }
}





?>