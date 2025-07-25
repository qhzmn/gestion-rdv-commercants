<?php

namespace Src\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Src\Model\UserModel;

class UserController
{
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }

    public function viewAddUser(){
        echo $this->twig->render('addUser.html.twig');
    }

    public function registerAddUser(){
        require_once __DIR__ . '/../Model/UserModel.php';
        require_once __DIR__ . '/../../config/database.php';
        $userModel = new UserModel($pdo);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $userModel->addUser($first_name, $last_name, $email, $password);
    }



}
?>
