<?php
//Autoload das classes work
require_once 'Lib/Work/Autoloaders/ClassLoader.php';
$cl= new Work\Autoloaders\ClassLoader;
$cl->addNamespace('Work','Lib/Work');
$cl->register();

//Autoload das classes App
require_once 'Lib/Work/Autoloaders/AppLoader.php';
$apl = new Work\Autoloaders\AppLoader;
$apl->addDirectory('App/Control');
$apl->addDirectory('App/Model');
$apl->register();

use Work\Database\Filter;
use Work\Database\Criterion;
use Work\Database\Multi;
use Work\Database\Transaction;
use Work\Loggers\LoggerXML;
$c1 = new Criterion;
$c1->add(new Filter('idade','>',15));

Transaction::open('bdu');
Transaction::setLogger(new LoggerXML('log_multi'));

$m1 = new Multi('Autor');
$result = $m1->load($c1);

foreach($result as $obj) {
	echo $obj->nome . "<br>\n";
}
?>