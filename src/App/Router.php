<?php

namespace App;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;

class Router implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$ctr = $app['controllers_factory'];

		$configFile = new JsonFile(__DIR__ . '/../../data/routes.json');

		$routes = $configFile->getFile();

		foreach ($routes as $name => $info)
		{
			$route = $ctr->match($info['path'], $info['controller']);

			if(isset($info['asserts'])){
				foreach ($info['asserts'] as $var => $regex) {
					$route->assert($var, $regex);
				}
			}

			if(isset($info['defaults'])){
				foreach ($info['defaults'] as $var => $val) {
					$route->value($var, $val);
				}
			}

			$route->bind($name);
		}

		return $ctr;
	}
}
