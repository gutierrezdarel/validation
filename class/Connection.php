<?php

class Connection
{
    private $user = 'root';
    private $pass = '';
    private $dbname = 'Login';
    public $pdo = null;

    public function con()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS $this->dbname");
            $this->pdo->exec("USE $this->dbname");

            $this->createTables();
            $this->insertDefaultRoles();
        } catch (PDOException $e) {
            echo "Connection failed:" . $e->getMessage();
        }

        return $this->pdo;
    }

    public function createTables()
    {
        // Create the users table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users(
                id int(6) AUTO_INCREMENT PRIMARY KEY,
                uname VARCHAR(50),
                pass VARCHAR(100),
                fullname VARCHAR(100) 
            )");

        // Create the roles table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS roles(
                id int(6) AUTO_INCREMENT PRIMARY KEY,
                user_type VARCHAR(50)
            )");

        // Create the user_role table with foreign key constraint
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS user_role(
                id int(6) AUTO_INCREMENT PRIMARY KEY,
                user_id int(6),
                role_id int(6),
                FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY(role_id) REFERENCES roles(id)
            )");

        // Create the post table with foreign key constraint
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS posts(
                id int(11) AUTO_INCREMENT PRIMARY KEY,
                user_id int(6) NOT NULL,
                content VARCHAR(255) NOT NULL,
                FOREIGN KEY(user_id) REFERENCES users(id)
        )");

        // Create the comments table with foreign key constraint
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS comments(
                id int(11) AUTO_INCREMENT PRIMARY KEY,
                user_id int(6) NOT NULL,
                post_id int(11 ) NOT NULL,
                replys VARCHAR(255) NOT NULL,
                FOREIGN KEY(user_id) REFERENCES users(id),
                FOREIGN KEY(post_id) REFERENCES posts(id)
        )");
    }

    public function insertDefaultRoles()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM roles");

        if ($stmt->fetchColumn() == 0) {
            $defaultRoles = [
                ['user_type' => 'ADMIN'],
                ['user_type' => 'GUIDANCE'],
                ['user_type' => 'STUDENT']
            ];

            $stmt = $this->pdo->prepare("INSERT INTO roles (user_type) VALUES (:user_type)");

            foreach ($defaultRoles as $role) {
                $stmt->execute($role);
            }
        }
    }
}
