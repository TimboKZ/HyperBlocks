<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/London');

$GLOBALS['base_url'] = 'http://timbo.kz/reddit/HyperBlocks/';
$GLOBALS['version'] = 'v0.4 Beta';

$GLOBALS['mysql_user'] = 'root';
$GLOBALS['mysql_password'] = '';
$GLOBALS['mysql_db'] = 'hyperblocks';


//require_once 'meekrodb.2.3.class.php';
//DB::$user = $GLOBALS['mysql_user'];
//DB::$password = $GLOBALS['mysql_password'];
//DB::$dbName = $GLOBALS['mysql_db'];
//DB::debugMode();