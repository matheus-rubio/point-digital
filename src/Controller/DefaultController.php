<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public $usuario;
    
    public function __construct()
    {
        if (isset($_SESSION) == false){
            session_start();
        }
        $this->usuario = [
            'nome' => isset($_SESSION['nome']) ? $_SESSION['nome'] : null,
            'isAdministrador' => isset($_SESSION['isAdministrador']) ? $_SESSION['isAdministrador'] : null,
        ];
    }
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {

        $data = [
            'titulo' => 'Home',
            'usuario' => $this->usuario,
        ];

        return $this->render('views/home.html.twig', $data);
    }
}
