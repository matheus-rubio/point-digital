<?php

namespace App\Controller;

use App\Model\LoginModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    public $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel;
    }
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

    /**
     * @Route("/logar", name="logar", methods={"POST"})
     */
    public function logar()
    {
        // PUXA AS INFORMAÇÕES DO FORMULÁRIO
        $infoLogin = [
            'login' => $_POST['login'],
            'senha' => md5($_POST['senha'])
        ];
        
        // VERIFICA SE FOI UTILIZADO EMAIL NO LOGIN, SE FOR BUSCA USUÁRIO NO BANCO
        if (str_contains($_POST['login'], "@")){
            $usuarioEncontrado = $this->loginModel->getUser($infoLogin);
            // SE ENCONTRAR USUÁRIO REDIRECIONA PARA PAGINA HOME
            if ( $usuarioEncontrado != null){
                $session = $this->get('session');
                $session->set('isAdministrador', false);
                $_SESSION['isAdministrador'] = false;
                $_SESSION['nome'] = $usuarioEncontrado['nome'];
                return $this->redirect("/home");
            }
        }
        // SENÃO BUSCA ADMIN NO BANCO
        else {
            $usuarioEncontrado = $this->loginModel->getAdmin($infoLogin);
            if ( $usuarioEncontrado != null){
                $session = $this->get('session');
                $session->set('isAdministrador', false);
                $_SESSION['isAdministrador'] = true;
                $_SESSION['nome'] = $usuarioEncontrado['nome'];
                return $this->redirect("/home");
            }
        }
        // SE NÃO FOI ENCONTRADO USUÁRIO RETORNA PARA A PAGINA DE LOGIN COM ERRO.
        if ($usuarioEncontrado == null){
            session_destroy();
            $_SESSION['erro'] = "Usuário ou senha incorreto";
            return $this->redirect("/login");
        }
    }
}
