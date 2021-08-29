<?php

namespace App\Controller;

use App\Model\ProdutosModel;
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

        $produtosModel = new ProdutosModel;
        $produtos = $produtosModel->getTodosProdutos();

        for ($i=0; $i < sizeof($produtos); $i++) {

            // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
            if(sizeof(explode('.', $produtos[$i]['preco'])) == 1){
                $produtos[$i]['preco'] = $produtos[$i]['preco'].",00";
            // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
            } else if(strlen(explode('.', $produtos[$i]['preco'])[1]) == 1){
                $produtos[$i]['preco'] = $produtos[$i]['preco']."0";
            }
             
            $produtos[$i]['preco'] = str_replace('.', ',', $produtos[$i]['preco']);
        }

        $data = [
            'titulo' => 'Home',
            'produtos' =>$produtos,
            'usuario' => $this->usuario,
        ];

        return $this->render('views/home.html.twig', $data);
    }
}
