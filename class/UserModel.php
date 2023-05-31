
<?php 

class UserModel extends Connection {


    public function InsertUser($insert_uname, $insert_password, $user_type, $fullname) {
        $con = $this->con();
    
        $hashedPassword = password_hash($insert_password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO `users` (`uname`, `pass`, `fullname`) VALUES (:username, :password,  :fullname )";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':username', $insert_uname);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':fullname', $fullname);
     
        if ($stmt->execute()) {
            $table1Id = $con->lastInsertId();
            $sql2 = "INSERT INTO `user_role`(`user_id`, `role_id`) VALUES (:user_id, :user_type)";
            $stmt2 = $con->prepare($sql2);
            $stmt2->bindParam(':user_type', $user_type);
            

            $stmt2->bindParam(':user_id', $table1Id);
            $stmt2->execute();
            return true;
        } else {
            return false;
        }
    }
    
    public function getUserByUsername($username){
       $con = $this->con();

       $query = "SELECT * FROM users WHERE uname=:username";
 
       $stmt = $con->prepare($query);
       $stmt->bindParam(":username", $username);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $role = $this->getUserRole($row['id']);
            return new User($row['id'], $row['uname'], $row['pass'], $role);
            // var_dump($role);

        }else{
            return null;
        }
    }

    private function getUserRole($userId)
    {   
        $con = $this->con();


        // echo $userId;

        $query = "SELECT r.id , r.user_type FROM roles as r JOIN user_role as ur ON r.id = ur.role_id WHERE ur.user_id = :userId";
        $stmt1 = $con->prepare($query);
        $stmt1->bindParam(":userId", $userId);
        $stmt1->execute();
        $role = [];

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            $role[] = new Role($row['id'], $row['user_type']); 
        }
        return $role;
    }

}