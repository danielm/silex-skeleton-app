<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();


$app->get('/', function(){
	return "Hello, Silex is now Running :)";
});

$app->run();
