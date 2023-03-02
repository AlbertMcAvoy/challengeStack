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
use App\Repository\BodyRepository;
use Doctrine\Common\Cache\Cache;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\UserNotFoundException;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{

    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private TokenStorageInterface $tokenStorage;
    private EncryptService $encryptService;
    private BodyRepository $bodyRepository;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, BodyRepository $bodyRepository, TokenStorageInterface $tokenStorage, EncryptService $encryptService)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->tokenStorage = $tokenStorage;
        $this->encryptService = $encryptService;
        $this->bodyRepository = $bodyRepository;
    }

    public function getCurrentUser(): UserInterface | null
    {
        $token = $this->tokenStorage->getToken();

        if ($token instanceof TokenInterface) {
            return $token->getUser();
        }

        return null;
    }


    public function update_user(array $data, UserInterface $user)
    {
        try{
            if (!empty($data)) {
                $userFinded = $this->userRepository->findOneBy(["id" => $user->getId()]);
                if (empty($userfinded)) throw new UserExistException();
                
                $userFromBdd = $this->encryptService->decryptData($userFinded);
    
                $userFromBdd->setFirstName($data['firstname'] ?? '');
                $userFromBdd->setLastName($data['lastname'] ?? '');
                $userFromBdd->setPhone($data['phone'] ?? '');
    
                if (isset($data['gender']) && is_int($data['gender'])) {
                    $userFromBdd->setGender(strval($data['gender']));
                }
                if (!empty($data['height']) && is_int($data['height'])) {
                    $userFromBdd->setHeight(strval($data['height']));
                }
                if (!empty($data['age']) && is_int($data['age'])) {
                    $userFromBdd->setAge(strval($data['age']));
                }
    
                if (!empty($data['objectif_weight']) && is_int($data['objectif_weight'])) {
                    $userFromBdd->setObjectifWeight(strval($data['objectif_weight']));
                }
    
                if (isset($data['weight']) && is_int($data['weight'])) { 
                    $body = new Body();
                    $body->setWeight($data['weight']);
                    if (!empty($userFromBdd->getObjectifWeight())) {
                        $body->setObjectifWeight($userFromBdd->getObjectifWeight());
                    }
                    $body->setDateTime(new DateTime());
                    $body->setUser($userFromBdd);
                    $this->bodyRepository->save($body, true);
                }
    
    
                $userEncrypted = $this->encryptService->encryptData($userFromBdd);
    
                $this->userRepository->save($userEncrypted, true);
    
                return true;
            }else {
                throw new UserFieldFromException();
            }
        } catch (UserExistException $e){
            throw new UserExistException();
        } catch (UserFieldFromException $e) {
            throw new UserFieldFromException();
        } catch (Exception $e) {
            throw new Exception();
        }
        
    }


    public function register(array $data)
    {
        $user = new User();
        try {
            if (!empty($data['email']) && !empty($data['password'])) {

                $userFind = $this->userRepository->findBy(["email" => $data["email"]]);
                if (empty($userFind)) {

                    $user->setEmail($data['email']);
                    $user->setFirstName($data['firstname'] ?? '');
                    $user->setLastName($data['lastname'] ?? '');
                    $user->setPhone($data['phone'] ?? '');

                    if (isset($data['gender']) && is_int($data['gender'])) {
                        $user->setGender(strval($data['gender']));
                    }
                    if (!empty($data['height']) && is_int($data['height'])) {
                        $user->setHeight(strval($data['height']));
                    }
                    if (!empty($data['age']) && is_int($data['age'])) {
                        $user->setAge(strval($data['age']));
                    }
                    if (!empty($data['objectif_weight']) && is_int($data['objectif_weight'])) {
                        $user->setObjectifWeight(strval($data['objectif_weight']));
                    }
                    $user->setSubscriptionDate(new DateTime());
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
        } catch (UserExistException $ex) {
            throw new UserExistException();
        } catch (UserFieldFromException $ex) {
            throw new UserFieldFromException();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
