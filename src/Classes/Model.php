<?php  

namespace App\Classes;

use App\Classes\Conexao;


abstract class Model{

	public $pdo;

	public function __construct(){
		$this->pdo = Conexao::connect();
	}

	public function fetchAll(){
		$sql = "SELECT * from $this->table";
		$list = $this->pdo->query($sql);
		return $list->fetchAll();
	}

	public function find($campo, $valor){
		$sql = "SELECT * from $this->table where $campo =?";
		$list = $this->pdo->prepare($sql);
		$list->bindValue(1, $valor);
		$list->execute();
		return $list->fetch();
	}
	public function findUpdate($campo, $value, $id){
		$sql = "SELECT * FROM $this->table WHERE $campo = ? AND id != ? ";
		$list = $this->pdo->prepare($sql);
		$list->bindValue(1, $value);
		$list->bindValue(2, $id);
		$list->execute();
		return $list->fetch();
	}
	public function delete($campo,$valor){
        $sql = "delete from $this->table where $campo = ?";
        $delete = $this->pdo->prepare($sql);
        $delete->bindValue(1,$valor);
        $delete->execute();
        return ($delete->rowCount() == 1) ? true : false;
    }
}