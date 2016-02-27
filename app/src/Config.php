<?php

namespace App;

use Symfony\Component\Yaml\Parser;
use Silex;

/*use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;*/

class Config {

	/**
	 * @var Silex\Application
	 */
	private $app;

	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @var string
	 */
	private $filename;

	public function __construct(Silex\Application $app, $file = null) {
		$this->filename = $file;
		$this->app = $app;
	}

	public function get($path, $default = null) {
		if (empty($this->data)){
			$this->data = $this->parseYaml();
		}

		$path = explode('/', $path);

		if (empty($path[0])) {
			return false;
		}

		$temp = &$this->data;
		$value = null;

		foreach ($path as $key) {
			if (!isset($temp[$key])) {
				$value = null;
				break;
			}
			$value = $temp[$key];
			$temp = & $temp[$key];
		}

		unset($temp);

		return $value !== null ? $value : $default;
	}

	/**
	 * @return mixed
	 */
	public function __isset($name) {
		return $this->get($name) !== null;
	}

	/**
	 * @return mixed
	 */
	public function __get($name) {
		return $this->get($name);
	}

	private function parseYaml() {
		$parser = new Parser();

		if (!is_readable($this->filename)) {
			return [];
		}

		$yml = $parser->parse(file_get_contents($this->filename) . "\n");

		unset($yml['__nodes']);

		return $yml ? : [];
	}
}
