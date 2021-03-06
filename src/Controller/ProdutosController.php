<?php 

namespace App\Controller;

use App\Model\ProdutosModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProdutosController extends AbstractController
{
    public $usuario;
    public $produtosModel;
    
    public function __construct()
    {
        if (isset($_SESSION) == false){
            session_start();
        }
        $this->produtosModel = new ProdutosModel;
        $this->usuario = [
            'id' => isset($_SESSION['id']) ? $_SESSION['id'] : null,
            'nome' => isset($_SESSION['nome']) ? $_SESSION['nome'] : null,
            'isAdministrador' => isset($_SESSION['isAdministrador']) ? $_SESSION['isAdministrador'] : null,
        ];
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
                $_SESSION['message'] = [
                    0 => 'error',
                    1 => "Você não tem permissão para acessar esta página",
                ];
                return $this->redirect("/home");

            } else {

                $produtos = $this->produtosModel->getTodosProdutos();

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
                    'titulo' => 'Gerenciar Produtos',
                    'usuario' => $this->usuario,
                    'produtos' => $produtos,
                ];

                return $this->render('/views/produtos/gerenciarProdutos.html.twig', $data);
            }
        } else {
            // SE NÃO ESTIVAR LOGADO RETORNA PRA PAGINA INICIAL E APRESENTA UMA MENSAGEM DE ERRO
            $_SESSION['message'] = [
                0 => 'error',
                1 => "Você precisa estar logado para acessar a página solicitada.",
            ];
            return $this->redirect("/home");
        }
        
    }

    /**
     * @Route("/visualizarProduto/{idProduto}", name="visualizarProduto", methods={"GET"})
     */
    public function visualizarProduto(int $idProduto)
    {
        $produto = $this->produtosModel->getProdutoById($idProduto);
        
        // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
        if(sizeof(explode('.', $produto['preco'])) == 1){
            $produto['preco'] = $produto['preco'].",00";
          // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
        } else if(strlen(explode('.', $produto['preco'])[1]) == 1){
            $produto['preco'] = $produto['preco']."0";
        }
        

        $produto['preco'] = str_replace('.', ',', $produto['preco']);

        $data = [
            'titulo'    => 'Produto',
            'produto'   => $produto,
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/produtos/visualizarProduto.html.twig', $data);
    }

    /**
     * @Route("/novoProduto", name="novoProduto")
     */
    public function novoProduto()
    {
        $data = [
            'titulo'    => 'Produto',
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/produtos/novoProduto.html.twig', $data);
    }

    /**
     * @Route("/cadastrarProduto", name="cadastrarProduto", methods="POST")
     */
    public function cadastrarProduto()
    {
        $produto = [
            'nome' => filter_var($_POST['nomeProduto'], FILTER_SANITIZE_STRING),
            'marca' => filter_var($_POST['marcaProduto'], FILTER_SANITIZE_STRING),
            'preco' => str_replace(',', '.', filter_var($_POST['valorProduto'], FILTER_SANITIZE_STRING)),
            'qnt_estoque' => filter_var($_POST['quantidadeProduto'], FILTER_SANITIZE_NUMBER_INT),
        ];

        $foiInserido = $this->produtosModel->insertProduto($produto);

        if ($foiInserido){

            $_SESSION['message'] = [
                0 => 'success',
                1 => "Produto cadastrado com sucesso!",
            ];

            return $this->redirect("/gerenciarProdutos");

        } else {

            $_SESSION['message'] = [
                0 => 'error',
                1 => "Erro ao cadastrar o produto!",
            ];

            return $this->redirect("/gerenciarProdutos");
        }
    }

    /**
     * @Route("/editarProduto/{idProduto}", name="editarProduto", methods="GET")
     */
    public function editarProduto($idProduto)
    {
        $produto = $this->produtosModel->getProdutoById($idProduto);

        $data = [
            'titulo'    => 'Produto',
            'idProduto' => $idProduto,
            'produto'   => $produto,
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/produtos/editarProduto.html.twig', $data);
    }

    /**
     * @Route("/atualizarProduto/{idProduto}", name="atualizarProduto", methods="POST")
     */
    public function atualizarProduto($idProduto)
    {
        $produto = [
            'nome' => filter_var($_POST['nomeProduto'], FILTER_SANITIZE_STRING),
            'marca' => filter_var($_POST['marcaProduto'], FILTER_SANITIZE_STRING),
            'preco' => filter_var($_POST['valorProduto'], FILTER_SANITIZE_STRING),
            'qnt_estoque' => filter_var($_POST['quantidadeProduto'], FILTER_SANITIZE_NUMBER_INT),
        ];

        $produtoFoiAtualizado = $this->produtosModel->updateProduto($produto, $idProduto);

        if ($produtoFoiAtualizado){

            $_SESSION['message'] = [
                0 => 'success',
                1 => "Produto atualizado com sucesso!",
            ];

            return $this->redirect("/gerenciarProdutos");

        } else {

            $_SESSION['message'] = [
                0 => 'error',
                1 => "Erro ao atualizar o produto!",
            ];

            return $this->redirect("/gerenciarProdutos");
        }
    }

    /**
     * @Route("/excluirProduto", name="excluirProduto")
     */
    public function excluirProduto(): void
    {
        $idProduto = $_POST['idProduto'];

        print_r($this->produtosModel->deleteProduto($idProduto));
        exit();
    }
    
}
