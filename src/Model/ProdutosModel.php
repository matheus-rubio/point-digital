<?php

namespace App\Model;

use App\Classes\Model;
use PDO;

class ProdutosModel extends Model
{    
    public function getTodosProdutos()
    {
        try {
            $sql = "SELECT * FROM public.tb_produtos";
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

}
