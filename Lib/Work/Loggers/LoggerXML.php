<?php
namespace Work\Loggers;

class LoggerXML extends Logger {
	public function write($message) {
		$time = date('H-i-s');
		$date = date('d-m-Y');
		$msg = "<log time={$time} date={$date}>\n";
		$msg .= "<message>{$message}</message>\n";
		$msg .= "</log>\n";
		
		$handler = fopen($this->file,'a');
		fwrite($handler,$msg);
		fclose($handler);
		
	}
}
?>