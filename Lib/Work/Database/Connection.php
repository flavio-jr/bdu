<?php
namespace Work\Database;

use PDO;
use Exception;

final class Connection {

	private function __construct() {}

	public static function open($config) {
		if(file_exists("App/Config/{$config}.ini")) {
			$db = parse_ini_file("App/Config/{$config}.ini");
		}
		else {
			throw new Exception("Arquivo {$config}.ini não encontrado");
		}

		$name = isset($db['name']) ? $db['name'] : NULL;
		$host = isset($db['host']) ? $db['host'] : NULL;
		$user = isset($db['user']) ? $db['user'] : NULL;
		$pass = isset($db['pass']) ? $db['pass'] : NULL;
		$type = isset($db['type']) ? $db['type'] : NULL;

		switch($type) {
			case 'mysql':
			$port = isset($db['port']) ? $db['port'] : '3306';
			$conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
			break;

			case 'pgsql':
			$port = isset($db['port']) ? $db['port'] : '5432';
			$conn = new PDO("pgsql:dbname={$name}; user={$user}; password={$pass};host=$host;port={$port}");
			break;

			case 'sqlite':
			$conn = new PDO("sqlite:{$name}");
		}
		$conn->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
		return $conn;
	}
}
?>
