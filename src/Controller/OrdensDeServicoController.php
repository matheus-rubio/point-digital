<?php 

namespace App\Controller;

use App\Model\OrdensDeServicoModel;
use App\Model\PedidosModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdensDeServicoController extends AbstractController
{
    public $usuario;
    public $ordensDeServicoModel;
    
    public function __construct()
    {
        if (isset($_SESSION) == false){
            session_start();
        }
        $this->ordensDeServicoModel = new OrdensDeServicoModel;
        $this->usuario = [
            'id' => isset($_SESSION['id']) ? $_SESSION['id'] : null,
            'nome' => isset($_SESSION['nome']) ? $_SESSION['nome'] : null,
            'isAdministrador' => isset($_SESSION['isAdministrador']) ? $_SESSION['isAdministrador'] : null,
        ];
    }

    /**
     * @Route("/gerenciarOrdens", name="gerenciarOrdens")
     */
    public function gerenciarOrdens()
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

                $ordens = $this->ordensDeServicoModel->getTodasOrdens();
                
                for ($i=0; $i < sizeof($ordens); $i++) {
                    ////////////// FORMATAÇÃO DO VALOR ORCAMENTO INICIAL ///////////////////
                    // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
                    if(sizeof(explode('.', $ordens[$i]['orcamento_inicial'])) == 1){
                        $ordens[$i]['orcamento_inicial'] = $ordens[$i]['orcamento_inicial'].",00";
                    // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
                    } else if(strlen(explode('.', $ordens[$i]['orcamento_inicial'])[1]) == 1){
                        $ordens[$i]['orcamento_inicial'] = $ordens[$i]['orcamento_inicial']."0";
                    }
                     
                    $ordens[$i]['orcamento_inicial'] = str_replace('.', ',', $ordens[$i]['orcamento_inicial']);

                    ////////////// FORMATAÇÃO DO VALOR FINAL ///////////////////
                    // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
                    if(sizeof(explode('.', $ordens[$i]['valor_final'])) == 1){
                        $ordens[$i]['valor_final'] = $ordens[$i]['valor_final'].",00";
                    // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
                    } else if(strlen(explode('.', $ordens[$i]['valor_final'])[1]) == 1){
                        $ordens[$i]['valor_final'] = $ordens[$i]['valor_final']."0";
                    }
                     
                    $ordens[$i]['valor_final'] = str_replace('.', ',', $ordens[$i]['valor_final']);
                }    

                $data = [
                    'titulo' => "Gerenciar OS's",
                    'usuario' => $this->usuario,
                    'ordens' => $ordens,
                ];

                return $this->render('/views/ordensDeServico/gerenciarOrdens.html.twig', $data);
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
     * @Route("/minhasOrdens", name="minhasOrdens")
     */
    public function minhasOrdens()
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

                $ordens = $this->ordensDeServicoModel->getOrdensCliente($this->usuario['id']);
                
                for ($i=0; $i < sizeof($ordens); $i++) {
                    ////////////// FORMATAÇÃO DO VALOR ORCAMENTO INICIAL ///////////////////
                    // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
                    if(sizeof(explode('.', $ordens[$i]['orcamento_inicial'])) == 1){
                        $ordens[$i]['orcamento_inicial'] = $ordens[$i]['orcamento_inicial'].",00";
                    // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
                    } else if(strlen(explode('.', $ordens[$i]['orcamento_inicial'])[1]) == 1){
                        $ordens[$i]['orcamento_inicial'] = $ordens[$i]['orcamento_inicial']."0";
                    }
                     
                    $ordens[$i]['orcamento_inicial'] = str_replace('.', ',', $ordens[$i]['orcamento_inicial']);

                    ////////////// FORMATAÇÃO DO VALOR FINAL ///////////////////
                    // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
                    if(sizeof(explode('.', $ordens[$i]['valor_final'])) == 1){
                        $ordens[$i]['valor_final'] = $ordens[$i]['valor_final'].",00";
                    // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
                    } else if(strlen(explode('.', $ordens[$i]['valor_final'])[1]) == 1){
                        $ordens[$i]['valor_final'] = $ordens[$i]['valor_final']."0";
                    }
                     
                    $ordens[$i]['valor_final'] = str_replace('.', ',', $ordens[$i]['valor_final']);
                }    

                $data = [
                    'titulo' => "Gerenciar OS's",
                    'usuario' => $this->usuario,
                    'ordens' => $ordens,
                ];

                return $this->render('/views/ordensDeServico/minhasOrdens.html.twig', $data);
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
     * @Route("/visualizarOS/{idOS}", name="visualizarOS", methods={"GET"})
     */
    public function visualizarOS(int $idOS)
    {
        $ordem = $this->ordensDeServicoModel->getOSByID($idOS);

        // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
        if(sizeof(explode('.', $ordem['orcamento_inicial'])) == 1){
            $ordem['orcamento_inicial'] = $ordem['orcamento_inicial'].",00";
        // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
        } else if(strlen(explode('.', $ordem['orcamento_inicial'])[1]) == 1){
            $ordem['orcamento_inicial'] = $ordem['orcamento_inicial']."0";
        }
         
        $ordem['orcamento_inicial'] = str_replace('.', ',', $ordem['orcamento_inicial']);

        // SE FOR NÚMERO INTEIRO ADICIONA DOIS ZEROS DEPOIS DA VIRGULA
        if(sizeof(explode('.', $ordem['valor_final'])) == 1){
            $ordem['valor_final'] = $ordem['valor_final'].",00";
        // SENÃO VERIFICA SE POSSUI UM NUMERO SÓ DEPOIS DA VIRGULA E ADICIONA UM ZERO  
        } else if(strlen(explode('.', $ordem['valor_final'])[1]) == 1){
            $ordem['valor_final'] = $ordem['valor_final']."0";
        }
         
        $ordem['valor_final'] = str_replace('.', ',', $ordem['valor_final']);

        $data = [
            'titulo'    => 'Ordem de Serviço',
            'ordem'   => $ordem,
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/ordensDeServico/visualizarOS.html.twig', $data);
    }

    /**
     * @Route("/novaOS", name="novaOS")
     */
    public function novaOS()
    {
        $clientes = $this->ordensDeServicoModel->getAllClients();

        $status = [
            "Pendente",
            "Finalizado",
            "Cancelado",
        ];

        $data = [
            'titulo'    => 'Nova OS',
            'clientes'  => $clientes,
            'status'    => $status,
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/ordensDeServico/novaOS.html.twig', $data);
    }

    /**
     * @Route("/cadastrarOS", name="cadastrarOS", methods="POST")
     */
    public function cadastrarOS()
    {
        $ordem = [
            'nome' => filter_var($_POST['nomePedido'], FILTER_SANITIZE_STRING),
            'marca' => filter_var($_POST['marcaPedido'], FILTER_SANITIZE_STRING),
            'preco' => str_replace(',', '.', filter_var($_POST['valorPedido'], FILTER_SANITIZE_STRING)),
            'qnt_estoque' => filter_var($_POST['quantidadePedido'], FILTER_SANITIZE_NUMBER_INT),
        ];

        $foiInserido = $this->ordensDeServicoModel->insertOS($ordem);

        if ($foiInserido){

            $_SESSION['message'] = [
                0 => 'success',
                1 => "Pedido cadastrado com sucesso!",
            ];

            return $this->redirect("/gerenciarPedidos");

        } else {

            $_SESSION['message'] = [
                0 => 'error',
                1 => "Erro ao cadastrar o pedido!",
            ];

            return $this->redirect("/gerenciarPedidos");
        }
    }

    /**
     * @Route("/editarOS/{idOS}", name="editarOS", methods="GET")
     */
    public function editarOS($idOS)
    {
        $ordem = $this->ordensDeServicoModel->getOSById($idOS);

        $status = [
            "Pendente",
            "Finalizado",
            "Cancelado",
        ];

        $data = [
            'titulo'    => 'Editar OS',
            'idOS' => $idOS,
            'ordem'   => $ordem,
            'status'    => $status,
            'usuario'   => $this->usuario,
        ];

        return $this->render('/views/ordensDeServico/editarOS.html.twig', $data);
    }

    /**
     * @Route("/atualizarOS/{idOS}", name="atualizarOS", methods="POST")
     */
    public function atualizarOS($idOS)
    {
        
        $ordem = [
            'data_finalizacao'      => $_POST['data_finalizacao']       != null ? filter_var($_POST['data_finalizacao'])                                : null,
            'modelo_aparelho'       => $_POST['modelo_aparelho']        != null ? filter_var($_POST['modelo_aparelho'], FILTER_SANITIZE_STRING)         : null,
            'status_servico'        => $_POST['status_servico']         != null ? filter_var($_POST['status_servico'], FILTER_SANITIZE_STRING)          : null,
            'problema_identificado' => $_POST['problema_identificado']  != null ? filter_var($_POST['problema_identificado'], FILTER_SANITIZE_STRING)   : null,
            'orcamento_inicial'     => $_POST['orcamento_inicial']      != null ? filter_var($_POST['orcamento_inicial'], FILTER_SANITIZE_STRING)       : null,
            'valor_final'           => $_POST['valor_final']            != null ? filter_var($_POST['valor_final'], FILTER_SANITIZE_STRING)             : null,
        ];

        $OSFoiAtualizada = $this->ordensDeServicoModel->updateOS($ordem, $idOS);

        if ($OSFoiAtualizada){

            $_SESSION['message'] = [
                0 => 'success',
                1 => "OS atualizada com sucesso!",
            ];

            return $this->redirect("/gerenciarOrdens");

        } else {

            $_SESSION['message'] = [
                0 => 'error',
                1 => "Erro ao atualizar a OS!",
            ];

            return $this->redirect("/gerenciarOrdens");
        }
    }    
}
