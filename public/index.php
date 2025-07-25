<?php
        session_start(); 


require_once __DIR__ . '/../vendor/autoload.php';

use Src\Controller\AppointmentController;
use Src\Controller\ConnectionController;
use Src\Controller\UserController;
use Src\Controller\ClientController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$retour = $_GET['return'] ?? null; // valeur par défaut

//$uri = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['id_user'])) {
    $uri = '/login';  
}


switch ($uri) {
    
    case '/':
        $controller = new AppointmentController();
        $controller->calendar();
        break;
    case '/list':
        $controller = new AppointmentController();
        $controller->list();
        break;
    case '/login':
        $controller = new ConnectionController();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method==='POST'){
            $controller->loginCheck();
        }else{
            $controller->loginForm();
        }
        break;
    case '/logout':
        $controller = new ConnectionController();
        $controller->logout();
        break;






    case '/client/view':
        $controller = new ClientController();
        $controller->viewClients();
        break;
    case '/client/delete':
        $controller = new ClientController();
        $controller->removeClient();
        break;
    case '/client/add':
        $controller = new ClientController();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method==='POST'){
            $controller->addClient();
        }else{
            $controller->viewAddClient();
        }
        break;





    case '/appointment/add':
        $controller = new AppointmentController();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method==='POST'){
            $controller->addHaircut();
        }else{
            $controller->formHaircut();
        }
        break;
    
    case '/addUser':
            $controller = new UserController();
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method==='POST'){
                $controller->registerAddUser();
            }else{
                $controller->viewAddUser();
            }
            break;
    case '/mentions':
        $controller = new AppointmentController();
        $controller->mentions();
        break;

    case '/politique':
        $controller = new AppointmentController();
        $controller->politiques();
        break;

        

    default:
    if ($retour){
    var_dump($retour);
    exit;
}
        http_response_code(404);
        echo "Page non trouvée";
        
        break;

}




?>



