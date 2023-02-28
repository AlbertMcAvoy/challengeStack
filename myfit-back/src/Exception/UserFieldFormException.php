<?php
namespace App\Exception;


class UserFieldFromException extends \Exception {

    public function __construct() {
        $this->message = "Error on the data send to the api. We cannot create user";
    }
}



?>