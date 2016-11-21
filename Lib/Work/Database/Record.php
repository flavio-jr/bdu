<?php
namespace Work\Database;

use Exception;
abstract class Record {
	protected $data;

	public function __construct($id = NULL) {
		if($id) {
			$reg = $this->find($id); //Carrega um registro com o id correspondente

			if(is_object($reg)) {
				$this->importData($reg->exportData()); //Usa o vetor $data de $reg no objeto carregado
			}

		}
	}

	public function __set($prop,$valor) {
		if(method_exists($this,'set_'.$prop)) {
			call_user_func(array($this,'set_'.$prop),$valor);
		}
		else {
			if($valor===NULL) {
				unset($this->data[$prop]);
			}
			else {
				$this->data[$prop] = $valor;
			}
		}
	}
	public function __get($prop) {
		if(method_exists($this,'get_'.$prop)) {
			return call_user_func(array($this,'get_'.$prop));
		}
		else {
			if(isset($this->data[$prop])) {
				return $this->data[$prop];
			}
		}
	}
	public function __isset($prop) {
		return isset($this->data[$prop]);
	}
	public function __unset($prop) {
		unset($this->data[$prop]);
	}
	public function importData($vetor) {
		$this->data = $vetor;
	}
	public function exportData() {
		return $this->data;
	}
	public function getModel() {
		$class = get_class($this);
		return constant("{$class}::TABLENAME");
	}
	public function getLastId() {
		$sql = "SELECT max(id) as max FROM " . $this->getModel();
		$conn = Transaction::get();
		$result = $conn->query($sql);
		$object = $result->fetchObject("stdClass");
		return $object->max;
	}

	public function find($id) {
		if($conn = Transaction::get()) {
			$sql = 'SELECT * FROM ' . $this->getModel() . ' WHERE id=' . (int)$id;
			Transaction::log($sql);
			$result = $conn->query($sql);
			if($result) {
				$object = $result->fetchObject(get_class($this));
			}
			return $object;
		}
		else {
			throw new Exception("Não há transação aberta");
		}
	}

	public static function onFind($id) {
		$class = get_called_class();
		$ar = new $class;
		return $ar->find($id);
	}

	public function save() {
		$dados = $this->toSQL();
		if($conn=Transaction::get()){
			if((!isset($this->data['id'])) or (!$this->find($this->id))) {
				$id = $this->getLastId() + 1;
				$dados['id'] = $id;
				$sql = "INSERT INTO " . $this->getModel() . '(';
			    $sql .= implode(',',array_keys($dados)) . ')';
			    $sql .= " VALUES(";
			    $sql .= implode(',',array_values($dados)) . ')';
			}
			else {
				$sql = "UPDATE " . $this->getModel() . " SET ";
				$foo = array();
				foreach($dados as $col=>$valor) {
					if($col!=='id') {
						$foo[] = "{$col} = {$valor}";
					}
				}
				$sql .= implode(',',$foo);
				$sql .= " WHERE id=" . $dados['id'];
			}
			Transaction::log($sql);
			return $conn->exec($sql);
		}
		else {
			throw new Exception("Não há transação ativa");
		}
	}

	public function toSQL() {
		$sql = array();
		foreach($this->data as $col=>$valor) {
			if(is_scalar($valor)) {
				if(is_string($valor)) {
				     $valor = addslashes($valor);
					 $sql[$col] = "'$valor'";
			     }
			     else if(is_bool($valor)) {
				     $sql[$col] = ($valor) ? 'TRUE' : 'FALSE';
			     }
			     else if($valor!='') {
				     $sql[$col] = $valor;
			     }
			     else {
				     $sql[$col] = "NULL";
			     }
			}
		}
		return $sql;
	}

	public function delete($id = NULL) {
		$id = ($id) ? $id : $this->data['id'];
		if($conn=Transaction::get()) {
			$sql = "DELETE FROM " . $this->getModel() . " WHERE id={$id}";
			Transaction::log($sql);
			return $conn->exec($sql);
		}
		else {
			throw new Exception("Não há transação ativa");
		}
	}
}
?>
