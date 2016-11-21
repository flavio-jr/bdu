<?php
namespace Work\Control;

class Page {
	public function show() {
		if($_GET) {
			$class = isset($_GET['class']) ? $_GET['class'] : NULL;
			$class = isset($_GET['method']) ? $_GET['method'] : NULL;
			
			if($class) {
				$object = ($class == get_class($this)) ? $this : new $class;
				if(method_exists($class,$method)) {
					call_user_func(array($object,$method),$_GET);
				}
			}
		}
	}
}
?>