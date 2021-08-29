<?php

namespace App\Model;

use App\Classes\Model;
use PDO;
use Symfony\Component\HttpFoundation\Response;

class LoginModel extends Model
{    
    public function getAdmin($parametros)
    {
        try {
            $sql = "SELECT * FROM public.tb_administradores
                    WHERE login = :login AND senha = :senha";
            $admins = $this->pdo->prepare($sql);
            foreach ($parametros as $key => $value) {
                $admins->bindValue(":{$key}", $value);
            }
            $admins->execute();
            return $admins->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getUser($parametros)
    {
        try {
            $sql = "SELECT * FROM public.tb_clientes
                    WHERE login = :login AND senha = :senha";
            $admins = $this->pdo->prepare($sql);
            foreach ($parametros as $key => $value) {
                $admins->bindValue(":{$key}", $value);
            }
            $admins->execute();
            return $admins->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function cadastrarCliente($parametros)
    {
        try {
            $sql = "INSERT INTO public.tb_clientes
                    (nome, login, senha)
                    VALUES(:nome, :login, :senha);";
            $admins = $this->pdo->prepare($sql);
            foreach ($parametros as $key => $value) {
                $admins->bindValue(":{$key}", $value);
            }
            $admins->execute();
            return  $admins->rowCount() >= 1 ? new Response('1'): new Response('0');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
