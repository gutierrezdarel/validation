<?php 

require_once 'controller/init.php';
// $action = isset($_GET['action']) ? $_GET['action'] : '';

// if($action === 'login'){
//     $controller = new UserController();
//     $controller->Login();
// }
 if(isset($_GET['action'])){
    $action = $_GET['action'];
    switch($action){
        case 'Login':
            $controller = new UserController();
            $controller->Login();
        case 'Register':
            $controller = new UserController();
            $controller->InsertU();
        case 'update':
            $userController = new UserManipulateController();
            $userController->updateUser();
        case 'delete':
            $userController = new UserManipulateController();
            $userController->deleteUser();
    }

 }

?>




 