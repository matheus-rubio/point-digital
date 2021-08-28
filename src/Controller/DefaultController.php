<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\ProdutosModel;

class DefaultController extends AbstractController
{
    public $usuario;
    public $produtosModel;
    
    public function __construct()
    {
        session_start();
        $this->produtosModel = new ProdutosModel;
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

    /**
     * @Route("/gerenciarProdutos", name="gerenciarProdutos")
     */
    public function gerenciarProdutos()
    {
        // SE ESTIVER LOGADO VERIFICA SE O USUÁRIO É ADMINISTRADOR
        if (isset($_SESSION['isAdministrador'])) {

            if ($_SESSION['isAdministrador'] == false) {

                // SE NÃO FOR ADMINISTRADOR NÃO PERMITE ACESSAR A PAGINA
                $_SESSION['message'] = "Você não tem permissão para acessar esta página";
                return $this->redirect("/home");

            } else {

                $produtos = $this->produtosModel->getTodosProdutos();

                $data = [
                    'titulo' => 'Home',
                    'usuario' => $this->usuario,
                    'produtos' => $produtos,
                ];

                return $this->render('/views/produtos/gerenciarProdutos.html.twig', $data);
            }
        } else {
            // SE NÃO ESTIVAR LOGADO RETORNA PRA PAGINA INICIAL E APRESENTA UMA MENSAGEM DE ERRO
            $_SESSION['message'] = "Você precisa estar logado para acessar a página solicitada.";
            return $this->redirect("/home");
        }
        
    }

    /**
     * @Route("/visualizarProduto", name="visualizarProduto")
     */
    public function visualizarProduto()
    {
        
    }
}
