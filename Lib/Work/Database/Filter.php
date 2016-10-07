<?php
namespace Work\Database;

class Filter extends Expression {
	protected $propriedade;
    protected $operador;
	protected $valor;
	
	public function __construct($prop,$op,$val) {
		$this->propriedade = $prop;
		$this->operador = $op;
		
		$this->valor = $this->valorSQL($val);
	}
	
	public function valorSQL($valor) {
			if(is_string($valor)) {
				$valor = addslashes($valor);
				return "'$valor'";
			}
			else if(is_bool($valor)) {
				$valor = ($valor) ? 'TRUE' : 'FALSE';
				return $valor;
			}
			else if(is_null($valor)) {
				return "NULL";
			}
			else if(is_array($valor)) {
				$foo = array();
				foreach($valor as $x) {
					if(is_string($x)) {
						$foo[] = "'$x'";
					}
					else if(is_integer($x)) {
						$foo[] = $x;
					}
				}
				return '(' . implode(',',$foo) . ')';
			}
			else {
				return $valor;
			}
	}
	
	public function format() {
		return "{$this->propriedade} {$this->operador} {$this->valor}";
	}
}
?>