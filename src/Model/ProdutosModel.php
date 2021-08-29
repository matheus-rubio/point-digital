<?php

namespace App\Model;

use App\Classes\Model;
use PDO;
use Symfony\Component\HttpFoundation\Response;

class ProdutosModel extends Model
{    
    public function getTodosProdutos()
    {
        try {
            $sql = "SELECT * FROM public.tb_produtos
                    ORDER BY id";
            $select = $this->pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getProdutoById($idProduto)
    {
        try {
            $sql = "SELECT * FROM public.tb_produtos
                    WHERE id = ?";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(1, $idProduto);
            $select->execute();
            return $select->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function insertProduto($produto)
    {
        try {
            $sql = "INSERT INTO public.tb_produtos
                    (nome, marca, preco, qnt_estoque)
                    VALUES(:nome, :marca, :preco, :qnt_estoque)";
            $insert = $this->pdo->prepare($sql);
            foreach ($produto as $key => $value) {
                $insert->bindValue(":{$key}", $value);
            }
            
            return $insert->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function updateProduto($produto, $idProduto)
    {
        try {
            $sql = "UPDATE public.tb_produtos
                    SET nome=:nome, marca=:marca, preco=:preco, qnt_estoque=:qnt_estoque
                    WHERE id={$idProduto};
                    ";       
            $update = $this->pdo->prepare($sql);
            foreach ($produto as $key => $value) {
                $update->bindValue(":{$key}", $value);
            }

            return $update->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function deleteProduto($idProduto)
    {
        try {
            $sql = "DELETE FROM public.tb_produtos
                    WHERE id= ?;
                    ";       
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(1, $idProduto);
            $delete->execute();
            return $delete->rowCount() >= 1 ? new Response('1') : new Response('0');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}
