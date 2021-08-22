<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(): Response
    {
        $data = [
            'titulo' => 'login',
            'controller_name' => 'LoginController',
        ];

        return $this->render('views/login.html.twig', $data);
    }
}
