<?php
namespace Work\Database;

class Criterion extends Expression {
	protected $expressions;
	protected $operators;
	protected $proprerties;
	
	public function __construct() {
		$this->expressions = array();
		$this->operators = array();
	}
	
	public function add(Expression $exp,$operator = self::AND_OPERATOR) {
		if(empty($this->expressions)) {
			$operator = NULL;
		}
		$this->expressions[] = $exp;
		$this->operators[] = $operator;
	}
	public function format() {
		$sql = '';
		if(count($this->expressions)>0) {
			foreach($this->expressions as $pos=>$valor) {
				$sql .= "{$this->operators[$pos]} {$valor->format()} ";
			}
		}
		$sql = trim($sql);
		return "({$sql})";
	}
	public function setProperty($property,$value) {
		if(isset($value)) {
			$this->properties[$property] = $value;
		}
		else {
			$this->properties[$property] = NULL;
		}
	}
	public function getProperty($property) {
		if(isset($this->properties[$property])) {
			return $this->properties[$property];
		}
	}
}
?>