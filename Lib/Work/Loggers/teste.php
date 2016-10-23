<?php
require_once 'Logger.php';
require_once 'LoggerXML.php';

$log = new Work\Loggers\LoggerXML('teste');
date_default_timezone_set('America/Sao_Paulo');
$log->write("Teste--1");
$log->write("Teste--2");
?>