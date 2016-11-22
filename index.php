<?php
date_default_timezone_set('America/Sao_Paulo');

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

$template = file_get_contents("App/Templates/template.html");
if(!$_GET) {
	$home = new Home;
	ob_start();
	$home->view();
	$content = ob_get_contents();
	ob_end_clean();
	echo str_replace("{{content}}",$content,$template);
}
else if($_GET) {
	$class = $_GET['class'];
	if(class_exists($class)) {
		$page = new $class;
		ob_start();
		$page->show();
		$content = ob_get_contents();
		ob_end_clean();
		echo str_replace("{{content}}",$content,$template);
	}

}
?>
