<?php
namespace Src\Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Src\Model\HaircutModel;
use Src\Model\ClientModel;
use Src\Model\AppointmentModel;



class HaircutController {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }
    
    

    

    
}


?>