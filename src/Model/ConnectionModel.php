<?php
namespace Src\Model;
class ConnectionModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }



    public function adduser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        
        $stmt->execute([$username, $hashedPassword]);
        return 1;
        
    }

    
    

    public function authenticate($username, $password) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? and is_active = 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $stmt = $this->db->prepare("UPDATE users SET last_login = ? WHERE id_user = ?");
        $stmt->execute([date('Y-m-d H:i:s'), $user['id_user']]);
        return $user; // Connexion réussie
    }

    return false; // Échec d’authentification
}

    
    
}
?>
