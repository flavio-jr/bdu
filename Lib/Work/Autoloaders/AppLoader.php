<?php
namespace Work\Autoloaders;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Exception;

class AppLoader {
	protected $folders = array();
	
	public function register() {
		spl_autoload_register(array($this,'loadClass'));
	}
	
	public function addDirectory($dir) {
		$this->folders[] = $dir;
	}
	
	public function loadClass($class) {
		foreach($this->folders as $entry){
			if(file_exists("{$entry}/{$class}.php")) {
				require "{$entry}/{$class}.php";
				return true;
			}
			else {
				if(file_exists($entry)) {
					foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($entry),RecursiveIteratorIterator::SELF_FIRST) as $try) {
						if(is_dir($try)) {
							if(file_exists("{$try}/{$class}.php")) {
								require_once "{$try}/{$class}.php";
								return true;
							}
						}
					}
				}
			}
		}
	}
}
?>