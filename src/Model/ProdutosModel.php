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
            $admins = $this->pdo->prepare($sql);
            $admins->execute();
            return $admins->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

}
