<?php

namespace Src\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Src\Model\ClientModel;
use Src\Model\AppointmentModel;

class ClientController
{
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }

    public function viewAddClient(){
        $return = $_GET['return'];
        echo $this->twig->render('addClient.html.twig', ['return' => $return]);
    }

    public function addClient(){
        require_once __DIR__ . '/../Model/HaircutModel.php';
        require_once __DIR__ . '/../../config/database.php';
        $userModel = new ClientModel($pdo);
        $last_name = trim($_POST['last_name'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $return = $_POST['return'] ?? '';
        $errors = [];

        if (strlen($last_name) < 2) {
            $errors[] = "Nom invalide.";
        }

        if (strlen($first_name) < 2) {
            $errors[] = "Prénom invalide.";
        }

        if (!preg_match('/^[0-9\s\-\+\(\)]{8,15}$/', $phone)) {
            $errors[] = "Téléphone invalide.";
        }

        if (!empty($errors)) {
            $_SESSION['client_error'] = implode(' ', $errors);
            header("Location: /client/view");
            exit;
        }
        $id_client = $userModel->addClient($last_name, $first_name, $phone);
        if ($id_client){
            $_SESSION['client_succes'] = "Succes client ajouté";
        }else{
            $_SESSION['client_error'] = "Erreur ajout client";
        }
        if($return=='appointment/add'){
            header("Location: /appointment/add?selected_client=" . $id_client);
            exit;
        }

    header("Location: /client/view");
    exit;
    }
    
         
    public function viewClients(){
        require_once __DIR__ . '/../Model/ClientModel.php';
        require_once __DIR__ . '/../../config/database.php';
        $clientModel = new ClientModel($pdo);
        $currentPath = $_SERVER['REQUEST_URI'];
        $clients =  $clientModel->getClients();
        $error = $_SESSION['client_error'] ?? null;
        $succes = $_SESSION['client_succes'] ?? null;
  
        unset($_SESSION['client_error']);
        unset($_SESSION['client_succes']);
        echo $this->twig->render('myclients.html.twig', ['currentPath' => $currentPath, 'clients' => $clients, 'error' => $error, 'succes' => $succes]);
    
    }

    public function removeClient(){
        require_once __DIR__ . '/../Model/ClientModel.php';
        require_once __DIR__ . '/../../config/database.php';
        $clientModel = new ClientModel($pdo);
        $id_client = $_POST['id_client'];
        $haircutModel = new AppointmentModel($pdo);
        $error1 = $haircutModel->deleteAppointment($id_client);
        $error2 =  $clientModel->removeClient($id_client);
        if (!$error1 && !$error2){
            $_SESSION['client_error'] = "Erreur suppression client";   
            header("Location: /client/view");
            exit;
        }
        $_SESSION['client_succes'] = "Succes client supprimé";
        header("Location: /client/view");
        exit;

    }




    

    


}
?>
