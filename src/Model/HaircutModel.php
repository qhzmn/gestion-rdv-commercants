<?php
namespace Src\Model;
class HaircutModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function getHaircut($prestation, $longueur) {
    $stmt = $this->db->prepare("SELECT id_haircut, duration, break FROM haircuts WHERE name = ? AND size = ?");
    $stmt->execute([$prestation, $longueur]);
    return $stmt->fetch(\PDO::FETCH_ASSOC); // Retourne un seul résultat ou false
    }
    





    



   
}

?>