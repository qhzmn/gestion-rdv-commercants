<?php
namespace Src\Model;


class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addUser($first_name, $last_name, $email, $password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $hashedPassword]);
        return $stmt->rowCount() > 0;
    }



    

    
    
}
?>
