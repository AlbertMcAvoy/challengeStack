<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class EncryptService
{

    private $encryptKey;

    public function __construct($encryptKey)
    {
        $this->encryptKey = $encryptKey;
    }

    public function encryptData(User $user): User | null
    {
        if (!empty($user) && !empty($user->getFirstName()) && !empty($user->getLastName())) {
            $iv = random_bytes(16);
            $data_to_encrypt = [
                "firstname" => $user->getFirstName(),
                "lastname" => $user->getLastName(),
            ];

            $data_encrypted = [];
            foreach ($data_to_encrypt as $key => $data) {
                $data_encrypted[$key] = openssl_encrypt(serialize($data), 'aes-256-cbc', $this->encryptKey, OPENSSL_RAW_DATA, $iv);
            }

            if (!empty($data_encrypted)) {
                $user->setFirstname(base64_encode($data_encrypted["firstname"]))
                    ->setLastname(base64_encode($data_encrypted["lastname"]))
                    ->setIv(base64_encode($iv));
                return $user;
            }
        }


        return null;
    }

    public function decryptData(UserInterface $userInterface): UserInterface {
        if(!empty($userInterface) && !empty($userInterface->getFirstName()) && !empty($userInterface->getLastName())) {
            $iv = base64_decode($userInterface->getIv());
            $data_to_decrypt = [
                "firstname" => base64_decode($userInterface->getFirstName()),
                "lastname" => base64_decode($userInterface->getLastName()),
            ];


            $data_decrypted = [];
            foreach ($data_to_decrypt as $key => $data) {
                $data_decrypted[$key] = unserialize(openssl_decrypt($data, 'aes-256-cbc', $this->encryptKey, OPENSSL_RAW_DATA, $iv));
            }


            if(!empty($data_decrypted)) {
                return $userInterface->setFirstname($data_decrypted["firstname"])
                ->setLastname($data_decrypted["lastname"]);
            }

        }
    }

}
