<?php
require_once 'Lib/Work/Autoloaders/ClassLoader.php';
$al = new Work\Autoloaders\ClassLoader;
$al->addNamespace('Work','Lib/Work');
$al->register();

Work\Database\Transaction::open('bdu');
?>