<?php
namespace Src\Model;
class ClientModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    

   
    public function getClients(){
        $stmt = $this->db->query("SELECT id_client, first_name, last_name, phone, last_purchase FROM clients WHERE is_active=1");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // tableau associatif de tous les produits
    }

    public function addClient($last_name, $first_name, $phone){
        $stmt = $this->db->prepare("INSERT INTO clients (first_name, last_name, phone) VALUES (?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $phone]);
        if ($stmt->rowCount() > 0) {
            return $this->db->lastInsertId();  // retourne l'ID du client ajouté
        } else {
            return false; // ou null selon ton choix
        }
    }
    public function updateClient($id_client){
        $stmt = $this->db->prepare("UPDATE clients SET last_purchase = CURRENT_TIMESTAMP  WHERE id_client = ?");
        $stmt->execute([$id_client]);
        return($stmt->rowCount() > 0);
    }

    public function removeClient($id_client){
        $stmt = $this->db->prepare("DELETE FROM clients WHERE id_client = ?");
        $stmt->execute([$id_client]);
        return($stmt->rowCount() > 0);
    }

    


    



   
}

?>