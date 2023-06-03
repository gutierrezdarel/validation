        <?php
        class UserController
        {
            private $UserModel;

            public function __construct()
            {
                $this->UserModel = new UserModel();
            }

            public function InsertU()
            {

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert-btn'])) {
                    $insert_uname = $_POST['insert_uname'];
                    $insert_password = $_POST['insert_pass'];
                    $user_type = $_POST['user_type'];
                    $fullname = $_POST['fullname'];

                    $insert = new $this->UserModel;

                    if ($insert->InsertUser($insert_uname, $insert_password, $user_type, $fullname)) {
                        header("location: View/Admin.php");
                    } else {
                        echo 'not inserted';
                    }
                }
            }



            public function Login()
            {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $UserModel = new $this->UserModel;

                    $validate =  $UserModel->getUserByUsername($username); 

                    if ($validate && $validate->authentication($password)) {
                        session_start();

                      $_SESSION['id'] = $validate->getId();
                      $_SESSION['username'] = $validate->getUsername();

                        $roles = $validate->getRole();

                        // Store the roles in the session
                        $_SESSION['roles'] = array_map(function($role) {
                            return $role->getName();
                        }, $roles);
                        
                        $this->redirectBasedOnUserRole($_SESSION['roles']);
    
                    } else {
                        echo 'Invalid password or username';
                        
                    }
                }

            }

               public function redirectBasedOnUserRole($role){


                switch(true){

                    case in_array('ADMIN', $role):
                        header('Location: View/Admin.php');
                        break;

                    case in_array('EMPLOYEE', $role):
                        header('Location: View/Employee.php');
                        break;

                    case in_array('COSTUMER', $role):
                        header('Location: View/Costumer.php');
                        break;
                    default:
                        echo 'no role';
                }
                // echo $role;
                // var_dump($role);
            }
        }
