<?php
use Work\Components\Post\Image;
use Work\Components\Base\Element;
use Work\Control\Page;

class Teste extends Page {
public function __construct(){
$img = new Image('App/Images/tyson.jpg');
$div = new Element('div');
$div->style = "height: 562.69px;width: 396.13px;";
$div->addChild($img);
$img->style = "height: inherit";

$div->open();
	}
}
?>