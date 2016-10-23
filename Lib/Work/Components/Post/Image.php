<?php
namespace Work\Components\Post;

use Work\Components\Base\Element;

class Image extends Element {
	public function __construct($path) {
		parent::__construct('img');
		$this->src = $path;
	}
}
?>