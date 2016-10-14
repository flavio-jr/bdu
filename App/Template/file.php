<?php
$s = file_get_contents('main.html');
$mudado = str_replace('{{content}}','<h1>JAJAJA</h1>',$s);
$f = str_replace('{{aqui}}','<h2>TIFABEQUINZE</h2>',$mudado);
echo $f;
?>