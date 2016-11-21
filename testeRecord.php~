<?php
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

use Work\Database\Transaction;
use Work\Loggers\LoggerXML;
use Work\Loggers\Logger;

try {
	Transaction::open('bdu');
    Transaction::setLogger(new LoggerXML('log_find'));

}
catch(Exception $e) {
	echo $e->getMessage();
}

?>