<?php 

class UserManipulateController {
    private $UserManipulate;

    public function __construct() {
        $this->UserManipulate = new UserManipulate();
    }

    public function displayUsers() {
        $users = $this->UserManipulate->getAllUsers();
        return $users;
    }

    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-btn'])) {
            $data = array(
                'id' => $_POST['id'],
                'update_uname' => $_POST['update_uname'],
                'update_fullname' => $_POST['update_fullname'],
                'update_usertype' => $_POST['user_type']
            );

            $success = $this->UserManipulate->updateUser($data);
            if ($success) {
                header("location: View/Admin.php");
            } else {
                echo 'Not Updated';
            }
        }
    }

    public function deleteUser(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_btn'])){
            $id = $_POST['delete_id'];

            $success = $this->UserManipulate->deleteUser($id);

            if($success){
                header("location: View/Admin.php");
            }else{
                echo 'Not Deleted';
            }
        }
    }
}