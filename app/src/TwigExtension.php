<?php
/**
 * TwigExtension.php - Silex Skeleton Application
 * 
 * LICENSE: This source file is distributed under the MIT licence terms.
 * Read the MIT-LICENSE.txt file for details.
 *
 * @package    Silex Skeleton Application
 * @author     Daniel Morales <daniminas@gmail.com>
 * @copyright  2014-2016 Daniel Morales
 * @license    MIT-LICENSE.txt
 * @version    0.2
 * @link       http://github.com/danielm/silex-skeleton-app
 */
namespace App;

class TwigExtension extends \Twig_Extension {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
	}

	public function getName() {
		return "appextensions";
	}

	public function getFilters() {
		return [
			"active" => new \Twig_Filter_Method($this, "active"),
		];
	}

	/*
	 * Simple filter that returns the word 'active' if the parameter $path
	 * (contains some URL) matches our current request.
	 * Usefull to generate Bootstrap navbars.
	 */
	public function active($path) {
		$request = $this->app['request_stack']
			->getMasterRequest()
			->getPathInfo();

		if ($path == '/') {
			return $path === $request ? 'active' : null;
		}

		return substr($request, 0, strlen($path)) === $path ? 'active' : null;
	}

	/*public function getFunctions() {
		return [
			"active" => new \Twig_Function_Method($this, 'active')
		];
	}*/
}
