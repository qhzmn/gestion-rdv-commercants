<?php

namespace Src\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Src\Model\ConnectionModel;

class ConnectionController
{
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }

    public function loginForm(){
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        echo $this->twig->render('form_connection.html.twig', ['error' => $error]);

    }

    public function loginCheck(){
        require_once __DIR__ . '/../Model/ConnectionModel.php';
        require_once __DIR__ . '/../../config/database.php';
        $userModel = new ConnectionModel($pdo);
        if (!isset($_POST['username'], $_POST['password'])) {
            $_SESSION['login_error'] = "Champs manquants."; 
            exit;
        }
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = "Champs vides non autorisés."; 
            exit;
        }
        $user = $userModel->authenticate($username, $password);
        if ($user) {
            $_SESSION = [];

            // Si l'utilisateur a été trouvé et l'authentification a réussi
            $_SESSION['id_user'] = $user['id_user'];  // ID utilisateur
            $_SESSION['email'] = $user['email'];      // Email de l'utilisateur
            unset($_SESSION['login_error']);
            header('Location: ../');
            exit;

        }else {
            $_SESSION['login_error'] = "Identifiants invalides. Veuillez réessayer.";   
            header('Location: /login'); // adapte le chemin selon ta config
            exit;         
        }
        
    }

    public function logout(){
        $_SESSION = [];
        session_destroy();
        header("Location: /");
        exit;


    }

    

    

}
?>
