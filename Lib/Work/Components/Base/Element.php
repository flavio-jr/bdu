<?php
namespace Work\Components\Base;

class Element {
	private $tag;
	private $children;
	private $attributes;
	public function __construct($tagname) {
		$this->tag = $tagname;
	}
	
	public function __set($attr,$value) {
		$this->attributes[$attr] = $value;
	}
	
	public function __get($attr) {
		return $this->attributes[$attr];
	}
	
	public function addChild($child) {
		$this->children[] = $child;
	}
	
	public function open() {
		echo "<{$this->tag}";
		
		if($this->attributes) {
			foreach($this->attributes as $attr=>$value) {
				echo " {$attr}=\"{$value}\"";
			}
		}
		echo ">\n";
		if($this->children) {
			foreach($this->children as $child) {
				if((is_string($child)) or (is_numeric($child))) {
					echo $child."\n";
				}
				else if(is_object($child)) {
					$child->open();
				}
			}
		}
		$this->close();
	}
	
	public function close() {
		echo "</{$this->tag}>\n";
	}
}
?>