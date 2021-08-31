<?php 

namespace App\Controller;

use App\Model\PedidosModel;
use App\Model\ProdutosModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PedidosController extends AbstractController
{
    public $usuario;
    public $pedidosModel;
    
    public function __construct()
    {
        if (isset($_SESSION) == false){
            session_start();
        }
        $this->pedidosModel = new PedidosModel;
        $this->usuario = [
            'id' => isset($_SESSION['id']) ? $_SESSION['id'] : null,
            'nome' => isset($_SESSION['nome']) ? $_SESSION['nome'] : null,
            'isAdministrador' => isset($_SESSION['isAdministrador']) ? $_SESSION['isAdministrador'] : null,
        ];
    }

    /**
     * @Route("/gerenciarPedidos", name="gerenciarPedidos")
     */
    public function gerenciarPedidos()
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

                $pedidos = $this->pedidosModel->getTodosPedidos();    
                
                for ($i=0; $i < sizeof($pedidos); $i++) {

                    // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
                    if(sizeof(explode('.', $pedidos[$i]['valor_total'])) == 1){
                        $pedidos[$i]['valor_total'] = $pedidos[$i]['valor_total'].",00";
                    // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
                    } else if(strlen(explode('.', $pedidos[$i]['valor_total'])[1]) == 1){
                        $pedidos[$i]['valor_total'] = $pedidos[$i]['valor_total']."0";
                    }
                     
                    $pedidos[$i]['valor_total'] = str_replace('.', ',', $pedidos[$i]['valor_total']);
                }    

                $data = [
                    'titulo' => 'Gerenciar Pedidos',
                    'usuario' => $this->usuario,
                    'pedidos' => $pedidos,
                ];

                return $this->render('/views/pedidos/gerenciarPedidos.html.twig', $data);
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
     * @Route("/visualizarPedido/{idPedido}", name="visualizarPedido", methods={"GET"})
     */
    public function visualizarPedido(int $idPedido)
    {
        $pedido = $this->pedidosModel->getPedidoById($idPedido);

        // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
        if(sizeof(explode('.', $pedido['valor_total'])) == 1){
            $pedido['valor_total'] = $pedido['valor_total'].",00";
        // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
        } else if(strlen(explode('.', $pedido['valor_total'])[1]) == 1){
            $pedido['valor_total'] = $pedido['valor_total']."0";
        }
         
        $pedido['valor_total'] = str_replace('.', ',', $pedido['valor_total']);

        
        $pedido['valor_total'] = str_replace('.', ',', $pedido['valor_total']);

        $data = [
            'titulo'    => 'Pedido',
            'pedido'   => $pedido,
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/pedidos/visualizarPedido.html.twig', $data);
    }

    /**
     * @Route("/confirmarPedido/{idProduto}", name="confirmarPedido")
     */
    public function confirmarPedido(int $idProduto)
    {
        // SE ESTIVER LOGADO VERIFICA SE O USUÁRIO É ADMINISTRADOR
        if (isset($_SESSION['isAdministrador'])) {

            if ($_SESSION['isAdministrador'] == true) {

                // SE FOR ADMINISTRADOR NÃO PERMITE ACESSAR A PAGINA
                $_SESSION['message'] = [
                    0 => 'error',
                    1 => "Você não tem permissão para acessar esta página",
                ];
                return $this->redirect("/home");

            } else {

                $produtosModel = new ProdutosModel;
                $produto = $produtosModel->getProdutoById($idProduto);

                $pedido = [
                    'id_cliente' => $this->usuario['id'],
                    'id_produto' => $idProduto,
                    'valor_total'=> $produto['preco'],
                    'status'     => "Pendente",
                    'codigo_de_barras' => "39993000000000014993739040736027668911000002"
                ];
                
                    // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
                    if(sizeof(explode('.', $pedido['valor_total'])) == 1){
                        $pedido['valor_total'] = $pedido['valor_total'].",00";
                    // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
                    } else if(strlen(explode('.', $pedido['valor_total'])[1]) == 1){
                        $pedido['valor_total'] = $pedido['valor_total']."0";
                    }
                     
                    $pedido['valor_total'] = str_replace('.', ',', $pedido['valor_total']);  

                $data = [
                    'titulo' => 'Realizar Pedido',
                    'usuario' => $this->usuario,
                    'pedido' => $pedido,
                    'produto'=> $produto,
                ];

                return $this->render('/views/pedidos/confirmarPedido.html.twig', $data);
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
     * @Route("/editarPedido/{idPedido}", name="editarPedido", methods="GET")
     */
    public function editarPedido($idPedido)
    {
        $pedido = $this->pedidosModel->getPedidoById($idPedido);

        $status = [
            "Pendente",
            "Finalizado",
            "Cancelado",
        ];

        $data = [
            'titulo'    => 'Editar Pedido',
            'idPedido' => $idPedido,
            'pedido'   => $pedido,
            'status'    => $status,
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/pedidos/editarPedido.html.twig', $data);
    }

    /**
     * @Route("/atualizarPedido/{idPedido}", name="atualizarPedido", methods="POST")
     */
    public function atualizarPedido($idPedido)
    {
        $pedido = [
            'status' => filter_var($_POST['statusPedido'], FILTER_SANITIZE_STRING),
        ];

        $pedidoFoiAtualizado = $this->pedidosModel->updatePedido($pedido, $idPedido);

        if ($pedidoFoiAtualizado){

            $_SESSION['message'] = [
                0 => 'success',
                1 => "Pedido atualizado com sucesso!",
            ];

            return $this->redirect("/gerenciarPedidos");

        } else {

            $_SESSION['message'] = [
                0 => 'error',
                1 => "Erro ao atualizar o pedido!",
            ];

            return $this->redirect("/gerenciarPedidos");
        }
    }

    /**
     * @Route("/excluirProduto", name="excluirProduto")
     */
    public function excluirProduto(): void
    {
        $idPedido = $_POST['idPedido'];

        print_r($this->pedidosModel->deleteProduto($idPedido));
        exit();
    }

    /**
     * @Route("/meusPedidos", name="meusPedidos")
     */
    public function meusPedidos()
    {
        // SE ESTIVER LOGADO VERIFICA SE O USUÁRIO É ADMINISTRADOR
        if (isset($_SESSION['isAdministrador'])) {

            if ($_SESSION['isAdministrador'] == true) {

                // SE NÃO FOR ADMINISTRADOR NÃO PERMITE ACESSAR A PAGINA
                $_SESSION['message'] = [
                    0 => 'error',
                    1 => "Você não tem permissão para acessar esta página",
                ];
                return $this->redirect("/home");

            } else {

                $pedidos = $this->pedidosModel->getPedidosCliente($this->usuario['id']);   
                
                for ($i=0; $i < sizeof($pedidos); $i++) {

                    // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
                    if(sizeof(explode('.', $pedidos[$i]['valor_total'])) == 1){
                        $pedidos[$i]['valor_total'] = $pedidos[$i]['valor_total'].",00";
                    // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
                    } else if(strlen(explode('.', $pedidos[$i]['valor_total'])[1]) == 1){
                        $pedidos[$i]['valor_total'] = $pedidos[$i]['valor_total']."0";
                    }
                     
                    $pedidos[$i]['valor_total'] = str_replace('.', ',', $pedidos[$i]['valor_total']);


                }    

                $data = [
                    'titulo' => 'Gerenciar Pedidos',
                    'usuario' => $this->usuario,
                    'pedidos' => $pedidos,
                ];

                return $this->render('/views/pedidos/meusPedidos.html.twig', $data);
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
     * @Route("/realizarPedido/{idProduto}", name="realizarPedido")
     */
    public function realizarPedido(int $idProduto)
    {
        // SE ESTIVER LOGADO VERIFICA SE O USUÁRIO É ADMINISTRADOR
        if (isset($_SESSION['isAdministrador'])) {

            if ($_SESSION['isAdministrador'] == true) {

                // SE NÃO FOR ADMINISTRADOR NÃO PERMITE ACESSAR A PAGINA
                $_SESSION['message'] = [
                    0 => 'error',
                    1 => "Você não tem permissão para acessar esta página",
                ];
                return $this->redirect("/home");

            } else {

                $produtosModel = new ProdutosModel;
                
                $produto = $produtosModel->getProdutoById($idProduto);
                
                $pedido = [
                    'id_cliente' => $this->usuario['id'],
                    'id_produto' => $idProduto,
                    'valor_total'=> $produto['preco'],
                    'status'     => "Pendente",
                    'codigo_de_barras' => "39993000000000014993739040736027668911000002"
                ];

                $pedidoEfetuado = $this->pedidosModel->insertPedido($pedido);

                $data = [
                    'titulo' => 'Realizar Pedidos',
                    'usuario' => $this->usuario,
                    'pedido'    => $pedido,
                    'pedidoEfetuado' => $pedidoEfetuado,
                ];

                return $this->render('/views/pedidos/conclusaoPedido.html.twig', $data);
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
    
}
