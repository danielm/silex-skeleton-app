<?php

namespace App\Provider;

use App;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigProvider implements ServiceProviderInterface {

	/**
	 * @param string $name
	 */
	public function __construct($name = 'config') {
		$this->name = $name;
	}

	/**
	 * @var string
	 */
	private $name;

	public function register(Container $app) {
		$keyname = $this->name;
		
		$app[$keyname] = function($app) use ($keyname){
			return new App\Config(
					$app,
					isset($app[$keyname . '.file']) ? $app[$keyname . '.file'] : null,
					isset($app[$keyname . '.cache']) ? $app[$keyname . '.cache'] : null
			);
		};
	}

}
