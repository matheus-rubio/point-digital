<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        session_start();
        $usuario = [
            'nome' => isset($_SESSION['nome']) ? $_SESSION['nome']: null,
            'isAdministrador' => isset($_SESSION['isAdministrador']) ? $_SESSION['isAdministrador']: null,
        ];
        
        $data = [
            'titulo' => 'Home',
            'usuario' => $usuario,
            'controller_name' => 'HomeController',
        ];

        return $this->render('views/home.html.twig', $data);
    }
}
