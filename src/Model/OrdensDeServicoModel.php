<?php

namespace App\Model;

use App\Classes\Model;
use PDO;
use Symfony\Component\HttpFoundation\Response;

class OrdensDeServicoModel extends Model
{    
    public function getTodasOrdens()
    {
        try {
            $sql = "SELECT 
                    id,
                    id_cliente,
                    to_char(data_inicio, 'dd/MM/YYYY HH24:MM') as data_inicio,
                    to_char(data_finalizacao, 'dd/MM/YYYY HH24:MM') as data_finalizacao,
                    modelo_aparelho,
                    status_servico,
                    problema_identificado,
                    orcamento_inicial,
                    valor_final
                    FROM public.tb_ordens_de_servico
                    ORDER BY id";
            $select = $this->pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getOrdensCliente($idCliente)
    {
        try {
            $sql = "SELECT 
                    id,
                    id_cliente,
                    to_char(data_inicio, 'dd/MM/YYYY HH24:MM') as data_inicio,
                    to_char(data_finalizacao, 'dd/MM/YYYY HH24:MM') as data_finalizacao,
                    modelo_aparelho,
                    status_servico,
                    problema_identificado,
                    orcamento_inicial,
                    valor_final
                    FROM public.tb_ordens_de_servico
                    WHERE id_cliente = ?
                    ORDER BY id";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(1, $idCliente);
            $select->execute();
            return $select->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getOSByID($idOS)
    {
        try {
            $sql = "SELECT 
                    id,
                    id_cliente,
                    to_char(data_inicio, 'dd/MM/YYYY HH24:MM') as data_inicio,
                    to_char(data_finalizacao, 'dd/MM/YYYY HH24:MM') as data_finalizacao,
                    modelo_aparelho,
                    status_servico,
                    problema_identificado,
                    orcamento_inicial,
                    valor_final
                    FROM public.tb_ordens_de_servico
                    WHERE id = ?";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(1, $idOS);
            $select->execute();
            return $select->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function insertOS($ordem)
    {
        try {
            $sql = "INSERT INTO public.tb_ordens_de_servico
                    (id_cliente, data_inicio, modelo_aparelho, status_servico, problema_identificado, orcamento_inicial)
                    VALUES(:id_cliente, now(), :modelo_aparelho, :status_servico, :problema_identificado, :orcamento_inicial);";
            $insert = $this->pdo->prepare($sql);
            foreach ($ordem as $key => $value) {
                $insert->bindValue(":{$key}", $value);
            }
            
            return $insert->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function updateOS($ordem, $idOS)
    {
        try {
            $sql = "UPDATE public.tb_ordens_de_servico
                    SET data_finalizacao=:data_finalizacao, 
                        modelo_aparelho=:modelo_aparelho, 
                        status_servico=:status_servico, 
                        problema_identificado=:problema_identificado, 
                        orcamento_inicial=:orcamento_inicial, 
                        valor_final=:valor_final
                    WHERE id={$idOS};
            
                    ";       
            $update = $this->pdo->prepare($sql);
            foreach ($ordem as $key => $value) {
                if ($value == null){
                    $update->bindValue(":{$key}", $value, PDO::PARAM_NULL);
                } else {
                    $update->bindValue(":{$key}", $value);
                }
            }

            return $update->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function deleteProduto($idOS)
    {
        try {
            $sql = "DELETE FROM public.tb_ordens_de_servico
                    WHERE id= ?;
                    ";       
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(1, $idOS);
            $delete->execute();
            return $delete->rowCount() >= 1 ? new Response('1') : new Response('0');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAllClients()
    {
        try {
            $sql = "SELECT * FROM public.tb_clientes";
            $select = $this->pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

}
