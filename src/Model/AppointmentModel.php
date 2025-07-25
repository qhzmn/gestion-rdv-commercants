<?php
namespace Src\Model;
class AppointmentModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getHaircut($prestation, $longueur) {
    $stmt = $this->db->prepare("SELECT id_haircut, duration, break FROM haircuts WHERE name = ? AND size = ?");
    $stmt->execute([$prestation, $longueur]);
    return $stmt->fetch(\PDO::FETCH_ASSOC); // Retourne un seul résultat ou false
    }

    public function getCalendar($id_user){
        $stmt = $this->db->prepare("SELECT CONCAT(haircuts.name, ' ', appointments.gender) AS title,
        appointments.start_time as start,
        appointments.end_time as end,
        CONCAT(clients.first_name, ' ', clients.last_name) AS name_client,
        clients.phone AS phone_client,
        CONCAT(users.first_name, ' ', users.last_name) AS user,
        color
        FROM appointments JOIN haircuts ON appointments.id_haircut=haircuts.id_haircut
        JOIN clients ON appointments.id_client=clients.id_client
        JOIN users ON appointments.id_user=users.id_user WHERE appointments.id_user = ?");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // tableau associatif de tous les produits
    }

    public function getListe($id_user){
        $stmt = $this->db->prepare("SELECT CONCAT(haircuts.name, ' ', appointments.gender) AS title,
        appointments.start_time as start,
        appointments.end_time as end,
        CONCAT(clients.first_name, ' ', clients.last_name) AS name_client,
        clients.phone AS phone_client,
        CONCAT(users.first_name, ' ', users.last_name) AS user,
        color
        FROM appointments JOIN haircuts ON appointments.id_haircut=haircuts.id_haircut
        JOIN clients ON appointments.id_client=clients.id_client
        JOIN users ON appointments.id_user=users.id_user
        WHERE end_time>CURRENT_TIMESTAMP() and appointments.id_user = ?
        ORDER BY start ASC");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // tableau associatif de tous les produits
    }


    public function isSlotFree($start_time, $end_time, $id_user) {
        $stmt = $this->db->prepare( "SELECT COUNT(*) FROM appointments WHERE NOT (end_time <= ? OR start_time >= ?) and id_user = ?");
        $stmt->execute([$start_time, $end_time, $id_user]);
        return $stmt->fetchColumn() == 0;  // true si aucun chevauchement
    }

    public function registerPrestation($start_time, $end_time, $id_client, $id_user, $id_haircut, $gender){
                $user_id = $_SESSION['user_id'];

        if (!$this->isSlotFree($start_time, $end_time, $id_user)) {
                throw new \Exception("Ce créneau est déjà pris.");
            }

        $stmt = $this->db->prepare("INSERT INTO appointments (start_time, end_time, id_client, id_user, id_haircut, gender) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$start_time, $end_time, $id_client, $id_user, $id_haircut, $gender]);
        return $stmt->rowCount() > 0;
    }

    public function deleteAppointment($id_client){
        $stmt = $this->db->prepare("DELETE FROM appointments WHERE id_client = ?");
        $stmt->execute([$id_client]);
        return $stmt->rowCount() > 0;

    }











    

   
}

?>