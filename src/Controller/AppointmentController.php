<?php
namespace Src\Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Src\Model\AppointmentModel;
use Src\Model\ClientModel;
require_once __DIR__ . '/../Model/AppointmentModel.php';


class AppointmentController {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }
    
    public function calendar() {
        require_once __DIR__ . '/../../config/database.php';
        $appointmentsModel = new AppointmentModel($pdo);
        $id_user = $_SESSION['id_user'];
        $appointments =  $appointmentsModel->getCalendar($id_user);
        $currentPath = $_SERVER['REQUEST_URI'];
        $error = $_SESSION['appointment_error'] ?? null;
        $succes = $_SESSION['appointment_succes'] ?? null;
        unset($_SESSION['appointment_error']);
        unset($_SESSION['appointment_succes']);
        echo $this->twig->render('homeCalendar.html.twig', ['currentPath' => $currentPath, 'events' => $appointments, 'error' => $error, 'succes' => $succes]);
    }

    public function list() {
        require_once __DIR__ . '/../../config/database.php';
        $appointmentsModel = new AppointmentModel($pdo);
        $id_user = $_SESSION['id_user'];
        $appointments =  $appointmentsModel->getListe($id_user);
        $currentPath = $_SERVER['REQUEST_URI'];
        $error = $_SESSION['appointment_error'] ?? null;
        $succes = $_SESSION['appointment_succes'] ?? null;
        unset($_SESSION['appointment_error']);
        unset($_SESSION['appointment_succes']);
        echo $this->twig->render('homeList.html.twig', ['currentPath' => $currentPath, 'events' => $appointments, 'error' => $error, 'succes' => $succes]);
    }

    public function formHaircut(){
        require_once __DIR__ . '/../Model/ClientModel.php';
        require_once __DIR__ . '/../../config/database.php';
        $currentPath = $_SERVER['REQUEST_URI'];
        $clientModel = new ClientModel($pdo);
        $clients = $clientModel->getClients();
        $selectedClient = (int) ($_GET['selected_client'] ?? null);
        $dateTimeRaw = $_GET['date'] ?? '';
        $date = '';
        $time = '';
        if ($dateTimeRaw) {
            try {
                $dt = new \DateTime($dateTimeRaw);
                // Formater date en YYYY-MM-DD
                $date = $dt->format('Y-m-d');
                // Formater heure en HH:MM
                $time = $dt->format('H:i');
            } catch (\Exception $e) {
                // En cas d'erreur, valeurs vides
                $date = '';
                $time = '';
            }
        }
        $error = $_SESSION['client_error'] ?? null;

        $succes = $_SESSION['client_succes'] ?? null;
        unset($_SESSION['client_error']);
        unset($_SESSION['client_succes']);
        echo $this->twig->render('formHaircut.html.twig', ['currentPath' => $currentPath, 'clients' => $clients, 'selected_client' => $selectedClient, 'date' => $date, 'time'=> $time, 'error' => $error, 'succes' => $succes]);  
    }

    public function addHaircut(){
        require_once __DIR__ . '/../../config/database.php';
        $id_user = $_SESSION['id_user'];
        $appointmentModel = new AppointmentModel($pdo);
        $id_client = $_POST['client'];
        $gender = $_POST['type'];
        $technique = $_POST['technique'] ?? null;
        $coupe = $_POST['coupe'] ?? null;
        $coiffage = $_POST['coiffage'] ?? null;
        $longueur = $_POST['longueur'] ?? 'court';
        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetimeDebut = \DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
        $now = new \DateTime();
        if ($datetimeDebut<$now){
            $_SESSION['appointment_error'] = "Heure indisponible.";
            header("Location: /");
            exit;
        }
        if ($technique && $technique!="none"){
            var_dump($technique);
            exit;
            $dataPrestation = $appointmentModel->getHaircut($technique, '');
            $id_technique = $dataPrestation['id_haircut'];
            $duration = $dataPrestation['duration'];
            $break = $dataPrestation['break'];

            $datetimeFin = clone $datetimeDebut;
            $datetimeFin->modify("+{$duration} minutes");
            $datetimeDebutSQLTechnique = $datetimeDebut->format('Y-m-d H:i:s');
            $datetimeFinSQLTechnique = $datetimeFin->format('Y-m-d H:i:s');
            if (!$appointmentModel->isSlotFree($datetimeDebutSQLTechnique, $datetimeFinSQLTechnique, $id_user)){
                $_SESSION['appointment_error'] = "Créneau déja pris."; 
                header("Location: /");
                exit;

            }
            $datetimeDebut = clone $datetimeFin;
            $datetimeDebut->modify("+{$break} minutes");  
        }
        if ($coupe && $coupe!="none"){
            $dataPrestation = $appointmentModel ->getHaircut($coupe, $longueur);
            $id_coupe = $dataPrestation['id_haircut'];
            $duration = $dataPrestation['duration'];
            
            $datetimeFin = clone $datetimeDebut;
            $datetimeFin->modify("+{$duration} minutes");
            $datetimeDebutSQLCoupe = $datetimeDebut->format('Y-m-d H:i:s');
            $datetimeFinSQLCoupe = $datetimeFin->format('Y-m-d H:i:s');
            if (!$appointmentModel->isSlotFree($datetimeDebutSQLCoupe, $datetimeFinSQLCoupe, $id_user)){
                $_SESSION['appointment_error'] = "Créneau déja pris."; 
                header("Location: /");
                exit;

            }
            $datetimeDebut = clone $datetimeFin;
        }
        if ($coiffage){
            $dataPrestation = $appointmentModel ->getHaircut($coiffage, $longueur);
            $id_coiffage = $dataPrestation['id_haircut'];
            $duration = $dataPrestation['duration'];
            
            $datetimeFin = clone $datetimeDebut;
            $datetimeFin->modify("+{$duration} minutes");
            $datetimeDebutSQLCoiffage = $datetimeDebut->format('Y-m-d H:i:s');
            $datetimeFinSQLCoiffage = $datetimeFin->format('Y-m-d H:i:s');
            if (!$appointmentModel->isSlotFree($datetimeDebutSQLCoiffage, $datetimeFinSQLCoiffage, $id_user)){
                $_SESSION['appointment_error'] = "Créneau déja pris."; 
                header("Location: /");
                exit;
            }  
        }
        if ($technique && $technique!="none"){
            $appointmentModel->registerPrestation($datetimeDebutSQLTechnique, $datetimeFinSQLTechnique, $id_client, $id_user, $id_technique, $gender);
        }
        if ($coupe && $coupe!="none"){
            $appointmentModel->registerPrestation($datetimeDebutSQLCoupe, $datetimeFinSQLCoupe, $id_client, $id_user, $id_coupe, $gender);
        }
        if ($coiffage){
            $appointmentModel->registerPrestation($datetimeDebutSQLCoiffage, $datetimeFinSQLCoiffage, $id_client, $id_user, $id_coiffage, $gender);
        }

        $userModel = new ClientModel($pdo);
        $userModel->updateClient($id_client);
        $_SESSION['appointment_succes'] = "RDV enregisté"; 
        header("Location: /");
        exit;
    }

    public function deleteAppointment(){
        require_once __DIR__ . '/../Model/HaircutModel.php';
        require_once __DIR__ . '/../../config/database.php';
        $appointmentModel = new AppointmentModel($pdo);
        $appointmentModel->deleteAppointment($id_haircut);

    }





    public function politiques() {
        
        echo $this->twig->render('politique_confidentialite.html.twig');
    }
    public function mentions() {
        
        echo $this->twig->render('mentions_legales.html.twig');
    }



    
}


?>