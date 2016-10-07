<?php
namespace Work\Database;

class Multi {
	private $activeRecord;
	
	public function __construct($class) {
		$this->activeRecord = $class;
	}
	
	public function load(Criterion $filter) {
		$sql = "SELECT * FROM " . constant("{$this->activeRecord}::TABLENAME");
		
		if($filter) {
			$sql .= " WHERE {$filter->format()}";
		}
		
		$order = $filter->getProperty('order');
		$limit = $filter->getProperty('limit');
		$offset = $filter->getProperty('offset');
		
		$sql .= ($order) ? "ORDER BY {$order}" : '';
		$sql .= ($limit) ? "LIMIT {$limit}" : '';
		$sql .= ($offset) ? "OFFSET {$offset}" : '';
		
		if($conn = Transaction::get()) {
			Transaction::log($sql);
			$result = $conn->query($sql);
			$objs = array();
			while($row = $result->fetchObject($this->activeRecord)) {
				$objs[] = $row;
			}
			return $objs;
		}
		else {
			throw new Exception("Não há transação ativa");
		}
	}
	
	public function delete(Criterion $filter) {
		$sql = "DELETE FROM " . constant("{$this->activeRecord}::TABLENAME");
		if($filter) {
			$sql .= " WHERE {$filter->format()}";
		}
		
		if($conn = Transaction::get()) {
			Transaction::log($sql);
			$result = $conn->exec($sql);
			return $result;
		}
		else {
			throw new Exception("Não há transação ativa");
		}
	}
	
}
?>
