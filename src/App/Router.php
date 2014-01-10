<?php

namespace App;

use Silex\Application;
use Silex\ControllerProviderInterface;

class Router implements ControllerProviderInterface
{
        private $_file;

        public function __construct($file = "routes.json") {
            $this->_file = $file;
        }

	public function connect(Application $app)
	{
		$ctr = $app['controllers_factory'];

		$configFile = new JsonFile(__DIR__ . '/../../data/' . $this->_file);

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
