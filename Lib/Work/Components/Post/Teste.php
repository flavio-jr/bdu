<?php
use Work\Components\Post\Image;
use Work\Components\Base\Element;

class Teste {
public function __construct(){
$img = new Image('tyson.jpg');
$div = new Element('div');
$div->style = "height: 562.69px;width: 396.13px;"
$div->addChild($img);
$img->style = "height: inherit";

$div->open();
	}
}
?>