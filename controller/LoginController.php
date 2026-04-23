<?php

class LoginController extends Login{
    private $user_name;
    private $pwd;
    private $user_id;

    public function __construct($user_name, $pwd, $user_id = null){
        $this->user_name = $user_name;
        $this->pwd = $pwd;
        $this->user_id = $user_id;
    }

    public function loginUser(){
        if($this->emptyInput() == true){
            throw new EmptyInputException("Empty input field");
            exit();
        }

        return $this->getUser($this->user_name, $this->pwd);
    }

    public function getUseFromDatabase(){
        return $this->fetchUserById($this->user_id);
    }

    private function emptyInput(){
        if (empty($this->user_name)|| empty($this->pwd)) {
            return true;
        }
        return false;
    }
}
