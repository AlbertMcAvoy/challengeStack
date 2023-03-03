<?php
namespace App\Exception;

class UserExistException extends \Exception {
    
    public function __construct() {
        $this->message = "User Already Exist";
    }

}