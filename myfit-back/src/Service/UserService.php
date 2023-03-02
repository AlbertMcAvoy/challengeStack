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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService {

    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private TokenStorageInterface $tokenStorage;
    private EncryptService $encryptService;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, TokenStorageInterface $tokenStorage, EncryptService $encryptService) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->tokenStorage = $tokenStorage;
        $this->encryptService = $encryptService;
    }

    public function getCurrentUser(): UserInterface | null
    {
        $token = $this->tokenStorage->getToken();

        if ($token instanceof TokenInterface) {
            return $this->encryptService->decryptData($token->getUser());
        }

        return null;
    }


    public function register(Array $data) {
        $user = new User();
        
       try {
        if (!empty($data['email']) && !empty($data['password'])) {

            $userFind = $this->userRepository->findBy(["email"=>$data["email"]]);
            
            if (empty($userFind)) {
                $user->setFirstName($data['firstname'] ?? '')
                ->setLastName($data['lastname'] ?? '')
                ->setGender($data['gender'] ?? null)
                ->setPhone($data['phone'] ?? null)
                ->setEmail($data['email'])
                ->setHeight($data['height'] ?? 0)
                ->setAge($data['age'] ?? null)
                ->setSubscriptionDate(new DateTime());
                $user->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']));

                $user = $this->encryptService->encryptData($user);

                if (!empty($data['weight']) && !empty($data['objectif_weight'])) {
                    $body = new Body();
                    $body->setWeight($data['weight'])
                    ->setObjectifWeight($data['objectif_weight'])
                    ->setDateTime(new DateTime());
                    $user->addBody($body);
                } 


                $this->entityManager->persist($user);
                $this->entityManager->flush();
            } else {
                throw new UserExistException();
            }  
         } else {
            throw new UserFieldFromException();
        }


        }catch(UserExistException $ex) {
            throw new UserExistException();
        } catch(UserFieldFromException $ex) {
            throw new UserFieldFromException();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
       }

    }
}
