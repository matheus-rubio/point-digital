<?php

namespace App\Model;

use App\Classes\Model;
use PDO;
use Symfony\Component\HttpFoundation\Response;

class PedidosModel extends Model
{    
    public function getTodosPedidos()
    {
        try {
            $sql = "SELECT 
                    pedido.id, 
                    pedido.id_cliente, 
                    pedido.id_produto, 
                    to_char(pedido.data_pedido, 'dd/MM/YYYY HH24:MM') as data_pedido, 
                    pedido.valor_total,
                    produto.nome as nome_produto, 
                    status 
                    FROM public.tb_pedidos as pedido
                    INNER JOIN public.tb_produtos as produto ON pedido.id_produto = produto.id
                    ORDER BY pedido.id";
            $select = $this->pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll(PDO::FETCH_ASSOC);
            exit();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getPedidosCliente($idCliente)
    {
        try {
            $sql = "SELECT 
                    pedido.id, 
                    pedido.id_cliente, 
                    pedido.id_produto, 
                    to_char(pedido.data_pedido, 'dd/MM/YYYY HH24:MM') as data_pedido, 
                    pedido.valor_total,
                    produto.nome as nome_produto, 
                    status 
                    FROM public.tb_pedidos as pedido
                    INNER JOIN public.tb_produtos as produto ON pedido.id_produto = produto.id
                    WHERE pedido.id_cliente = ?
                    ORDER BY pedido.id";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(1, $idCliente);
            $select->execute();
            return $select->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getPedidoById($idPedido)
    {
        try {
            $sql = "SELECT 
                    pedido.id, 
                    pedido.id_cliente, 
                    pedido.id_produto, 
                    to_char(pedido.data_pedido, 'dd/MM/YYYY HH24:MM') as data_pedido, 
                    pedido.valor_total,
                    produto.nome as nome_produto, 
                    status 
                    FROM public.tb_pedidos as pedido
                    INNER JOIN public.tb_produtos as produto ON pedido.id_produto = produto.id
                    WHERE pedido.id = ?";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(1, $idPedido);
            $select->execute();
            return $select->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function insertPedido($pedido)
    {
        try {
            $sql = "INSERT INTO public.tb_pedidos
                    (id_cliente, id_produto, data_pedido, valor_total, status)
                    VALUES(:id_cliente, :id_produto, :data_pedido, :valor_total, :status);
            ";
            $insert = $this->pdo->prepare($sql);
            foreach ($pedido as $key => $value) {
                $insert->bindValue(":{$key}", $value);
            }
            
            return $insert->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function updatePedido($pedido, $idPedido)
    {
        try {
            $sql = "UPDATE public.tb_pedidos
                    SET status=:status
                    WHERE id={$idPedido};
                    ";       
            $update = $this->pdo->prepare($sql);
            foreach ($pedido as $key => $value) {
                $update->bindValue(":{$key}", $value);
            }

            return $update->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function deleteProduto($idPedido)
    {
        try {
            $sql = "DELETE FROM public.tb_pedidos
                    WHERE id= ?;
                    ";       
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(1, $idPedido);
            $delete->execute();
            return $delete->rowCount() >= 1 ? new Response('1') : new Response('0');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}
