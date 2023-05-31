<?php 

class UserManipulate extends Connection {



    public function getAllUsers(){
        $con = $this->con();

        $query = "SELECT u.uname, u.fullname, r.user_type 
        FROM users AS u
        JOIN user_role AS ur ON u.id = ur.user_id
        JOIN roles AS r ON ur.role_id = r.id";
;
        $stmt = $con->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $users;
    }
}