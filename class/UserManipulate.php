<?php 

class UserManipulate extends Connection {
    


    public function getAllUsers(){
        $con = $this->con();

        $query = "SELECT u.uname, u.fullname, r.user_type, u.id
        FROM users AS u
        JOIN user_role AS ur 
        ON u.id = ur.user_id
        JOIN roles AS r ON ur.role_id = r.id";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $users;
    }
    public function updateUser($data){
        $con = $this->con();

        $query = "UPDATE users as u 
                  INNER JOIN user_role  as ur 
                  ON u.id = ur.user_id
                  SET u.uname = :username, u.fullname = :fullname, ur.role_id = :role 
                  WHERE u.id = :id";
        $stmt = $con->prepare($query);
        $success = $stmt->execute([
                        ':id' => $data['id'],
                        ':username' => $data['update_uname'],
                        ':fullname' => $data['update_fullname'],
                        ':role' => $data['update_usertype'] ]);       
            
            return $success;    
    }
    public function deleteUser($id){
        $con = $this->con();

        try{
            $con->beginTransaction();
            $hasrole =$this->checkrecords($id);

            if($hasrole){
                $query = "DELETE users, user_role FROM users 
                          LEFT JOIN user_role ON users.id = user_role.user_id 
                          WHERE users.id = :id";
                 $stmt = $con->prepare($query);
                 $success = $stmt->execute([':id' => $id]);
            }else{
                $query= "DELETE FROM users WHERE id = :id";
                $stmt = $con->prepare($query);
                $success = $stmt->execute([':id' => $id]);
            }

            if($success){
                $con->commit();
                return true;
            }else{
                $con->rollBack();
                return false;
            }

        }catch(PDOException $e){
            $con->rollBack();
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }

        // $query = "DELETE FROM users WHERE ";

    }

    public function checkrecords($id){
        $con = $this->con();

        $query = "SELECT COUNT(*) FROM user_role WHERE user_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute([':id' => $id]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}