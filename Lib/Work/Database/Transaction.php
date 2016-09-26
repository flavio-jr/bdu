<?php
namespace Work\Database;

class Transaction {
	private static $conn;
	
	public function __construct(){}
	
	public static function open($config) {
		if(empty(self::$conn)) {
			self::$conn = Connection::open($config);
			self::$conn->beginTransaction();
			echo "Open OK!<br>\n";
		}
		
	}
	public static function close() {
		if(self::$conn) {
			self::$conn->commit();
			self::$conn = NULL;
			echo "Close Ok!<br>\n";
		}
	}
	public static function get() {
		return self::$conn;
		echo "Ok!";
	}
	public static function rollBack() {
		if(self::$conn) {
			self::$conn->rollback();
			self::$conn = NULL;
		}
	}
}
?>