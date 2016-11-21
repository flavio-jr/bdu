<?php
namespace Work\Loggers;

abstract class Logger {
	protected $file;

	public function __construct($filename) {
		$this->file = "Lib/Work/Loggers/logs/{$filename}.xml";
		file_put_contents($this->file,"<comandos>\n");
	}

	abstract function write($message);
}
?>
