<?php
namespace Work\Database;

use Work\Loggers\Logger;
use Work\Loggers\LoggerXML;
class Transaction {
	private static $conn;
	private static $logger;
	
	public function __construct(){}
	
	public static function open($config) {
		if(empty(self::$conn)) {
			self::$conn = Connection::open($config);
			self::$conn->beginTransaction();
		}
		
	}
	public static function close() {
		if(self::$conn) {
			self::$conn->commit();
			self::$conn = NULL;
		}
	}
	public static function get() {
		return self::$conn;
	}
	public static function rollBack() {
		if(self::$conn) {
			self::$conn->rollback();
			self::$conn = NULL;
		}
	}
	public static function setLogger(Logger $obj) {
		self::$logger = $obj;
	}
	public static function log($message) {
		if(self::$logger) {
			self::$logger->write($message);
		}
	}
}
?>