<?php 

    class Connection{
        private $user = 'root';
        private $pass = 'Allen is Great 200%';
        private $dbname = 'Login';
        public $pdo = null;

        public function con(){
            try{
                $this->pdo = new PDO("mysql:host=localhost;", $this->user, $this->pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $this->pdo->exec("CREATE DATABASE IF NOT EXISTS $this->dbname");
                $this->pdo->exec("USE $this->dbname");
                $this->pdo->exec("CREATE TABLE IF NOT EXISTS users(
                    id int(6) AUTO_INCREMENT PRIMARY KEY,
                    uname VARCHAR(50),
                    pass VARCHAR(100),
                    fullname VARCHAR(100)
                )");

                $this->pdo->exec("CREATE TABLE IF NOT EXISTS roles(
                    id int(6) AUTO_INCREMENT PRIMARY KEY,
                    user_type VARCHAR(50)
                )");
                
                 $this->pdo->exec("CREATE TABLE IF NOT EXISTS user_role(
                    id int(6) AUTO_INCREMENT PRIMARY KEY,
                    user_id int(6),
                    role_id int(6),
                    FOREIGN KEY(user_id) REFERENCES users(id),
                    FOREIGN KEY(role_id) REFERENCES roles(id)
                )");

            }catch(PDOException $e){
                echo "Connection failed:" . $e->getMessage();
            }
            return $this->pdo;
        }

    }

?>