<?php
require_once 'Element.php';

$h1 = new Element('div1');
$h1->style = "background-color: black";
$h1->addChild('Teste h1');
$h2 = new Element('div2');
$h2->addChild('Teste h2');
$h1->addChild($h2);

$h1->open();
?>