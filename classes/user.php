<?php
include "../pages/php.php";

class User {
    private $name;

    private $email;

    private $password;


    public function __construct(PDO $name, $email, $password){
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }



}