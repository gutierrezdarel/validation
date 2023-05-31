<?php 

class UserManipulateController {

    private $UserManipulate;

    public function  __construct()
    {
        $this->UserManipulate = new UserManipulate();
    }

    public function displayUsers(){

        $users = $this->UserManipulate->getAllUsers();

        return $users;
    }
}