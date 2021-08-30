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
            'titulo' => 'Login',
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
                $_SESSION['id'] = $usuarioEncontrado['id'];
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

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        session_start();
        session_destroy();
        return $this->redirect("/home");
    }

    /**
     * @Route("/registrar", name="registrar")
     */
    public function registrar()
    {
        $data = [
            'titulo' => 'cadastrar',
        ];

        return $this->render('views/registrar.html.twig', $data);
    }

    /**
     * @Route("/cadastrarUsuario", name="cadastrarUsuario")
     */
    public function cadastrarUsuario(): void
    {
        $usuario = [
            'nome'  => filter_var($_POST['nome'], FILTER_SANITIZE_STRING),
            'login' => filter_var($_POST['login'], FILTER_SANITIZE_STRING),
            'senha' => md5(filter_var($_POST['senha'], FILTER_SANITIZE_STRING)),
        ];
        
        $usuarioCadastrado = $this->loginModel->cadastrarCliente($usuario);
        print_r($usuarioCadastrado);
        exit();
    }
}
