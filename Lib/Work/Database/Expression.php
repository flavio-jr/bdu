<?php
namespace Work\Database;

abstract class Expression {
	const AND_OPERATOR = "AND";
	const OR_OPERATOR = "OR";
	
	// Formata a expressão para ser processada pelo banco de dados
	abstract function format();
}
?>