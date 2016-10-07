<?php
namespace Work\Autoloaders;
class ClassLoader {
	protected $prefixes = array();
	
	public function register() {
		spl_autoload_register(array($this,'loadClass'));
	}
	
	public function addNamespace($prefix,$base) {
		$prefix = trim($prefix) . '\\';
		$base = rtrim($base,DIRECTORY_SEPARATOR) . '/';
		
		if(!isset($this->prefixes[$prefix])) {
			$this->prefixes[$prefix] = array();
		}
		
		array_push($this->prefixes[$prefix],$base);
	}
	
	public function loadClass($class) {
		$prefix = $class;
		
		while(false !== $pos=strrpos($prefix,'\\')) {
			$prefix = substr($class,0,$pos+1);
			$relative_class = substr($class,$pos+1);
			$mappedFile = $this->mapFile($prefix,$relative_class);
			if($mappedFile) {
				return $mappedFile;
			}
			$prefix = rtrim($prefix,'\\');
		}
		return false;
	}
	
	public function mapFile($base,$class) {
		if(isset($this->prefixes[$base]) === false) {
			return false;
		}
		else {
			foreach($this->prefixes[$base] as $entry) {
				$file = $entry . str_replace('\\','/',$class) . '.php';
				$ok = $this->requireFile($file);
				if($ok) {
					return true;
				}
			}
		}
		return false;
	}
	
	public function requireFile($file) {
		if(file_exists($file)){
			require $file;
			return true;
		}
		else {
			return false;
		}
	}
}
?>