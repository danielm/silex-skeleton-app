<?php

namespace App;

class TwigExtension extends \Twig_Extension {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
	}

	public function getName() {
		return "appextensions";
	}

	public function getFunctions() {
		return array(
			"ping" => new \Twig_Function_Method($this, 'ping')
		);
	}

	public function ping() {
		return "pong";
	}

	/* public function getFilters()
	  {
	  return array(
	  "test" => new \Twig_Filter_Method($this, "test"),
	  );
	  } */
}
