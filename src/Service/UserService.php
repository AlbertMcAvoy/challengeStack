<?php 
namespace App\Service;

use App\Entity\User;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Exception\UserExistException;

class UserService {

    private $userPasswordHasher;
    private $entityManager;
    private $userRepository;


    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function register(Array $data) {
        $user = new User();
        
       try {
        if (!empty($data['firstname']) && !empty($data['lastname']) && !empty($data['email']) && !empty($data['password'])) {

            $userFind = $this->userRepository->findBy(["email"=>$data["email"]]);

            if (empty($userFind)) {
                $user->setFirstName($data['firstname'])
                ->setLastName($data['lastname'])
                ->setEmail($data['email'])
                ->setSubscriptionDate(new DateTime());

                $user->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']));


                $this->entityManager->persist($user);
                $this->entityManager->flush();
            } else {
                throw new UserExistException();
            }
         }


        }catch(UserExistException $ex) {
            throw new UserExistException();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
       }

    }
}
