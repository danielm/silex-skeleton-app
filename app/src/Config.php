<?php
/**
 * Config.php - Silex Skeleton Application
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

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;
use Silex;

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

		if (false === is_file($this->filename)) {
			throw new FileNotFoundException(sprintf('Config file not found "%s".', $this->filename));
		}

		if (false === $config = @file_get_contents($this->filename)) {
			throw new IOException(sprintf('Failed to load config file "%s".', $this->filename));
		}

		try {
			$config = $parser->parse($config);
		} catch (ParseException $e) {
			throw new IOException(sprintf('Failed to parse config file "%s". %s', $this->filename, $e->getMessage()), $e->getCode(), $e);
		}

		return $config;
	}
}
