<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

    class UserManager extends AbstractManager {
        public function __construct(){
            parent::__construct();
        }
        
        public function findByEmail(string $email){
            $query = $this -> db -> prepare('
                SELECT * FROM users
                WHERE email = :email
            ');
            
            $parameters = [
                'email' => $email
            ];
            
            $query -> execute($parameters);
            
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if($result !== false){
                $user = new User($result["username"], $result["email"], $result["password"], $result["role"], $result["created_at"], $result["id"]);
                return $user;
            }
            else{
                return null;
            }
        }
        
        public function findOne(int $id){
            $query = $this -> db -> prepare('
                SELECT * FROM users
                WHERE id = :id
            ');
            
            $parameters = [
                'id' => $id
            ];
            
            $query -> execute($parameters);
            
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if($result !== false){
                $user = new User($result["username"], $result["email"], $result["password"], $result["role"], $result["created_at"], $result["id"]);
                return $user;
            }
            else{
                return null;
            }
        }
        
        public function create(User $user){
            
            $query = $this -> db -> prepare("
                INSERT INTO users (username, email, password, role, created_at) 
                VALUES (:username, :email, :password, :role, :createdAt)
            ");
            
            $parameters = [
                "username" => $user -> getUsername(),
                "email" => $user -> getEmail(),
                "password" => $user -> getPassword(),
                "role" => $user -> getRole(),
                "createdAt" => $user -> getCreatedAt()
            ];
            
            $query -> execute($parameters);
            
        }
    }
?>