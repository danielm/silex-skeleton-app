<?php
/**
 * Application.php - Silex Skeleton Application
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

use Silex;
use App;

class Application extends Silex\Application {

	public function initApplication() {
		$this->initConfig();

		$this['debug'] = $this['config']->get('debug');
		if ($this['debug']) {
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}

		if ($timezone = $this['config']->get('timezone')) {
			date_default_timezone_set($timezone);
		}

		$this->initCache();
		$this->initTwig();
		$this->initDoctrine();
		$this->initSession();
		$this->initLogging();
		$this->initLocales();
		$this->initForms();
		$this->initAssets();
		$this->initSwiftmailer();

		$this->initControllers();

		// Handlers
        $this->error(array($this, 'errorHandler'));
	}

	protected function initConfig() {
		$this->register(new App\Provider\ConfigProvider('config'), array(
			'config.file' => __DIR__ . '/../../config/general.yml'
		));
	}

	protected function initCache() {
		if($config = $this['config']->get('memcached')){
			$this->register(new App\Provider\MemcachedProvider(), array(
				'memcached.options' => $config
			));
		}
	}

	protected function initTwig() {
		$this->register(new Silex\Provider\TwigServiceProvider(), array(
			'twig.path' => __DIR__ . '/../../views',
			'twig.options' => array(
				'cache' => $this['debug'] ? __DIR__ . '/../../cache/twig' : false,
				'auto_reload' => $this['debug']
			)
		));

		$this->extend('twig', function($twig, $app) {
			$twig->addExtension(new App\TwigExtension($app));
			return $twig;
		});
	}

	protected function initSession() {
		$this->register(new Silex\Provider\SessionServiceProvider());
	}

	protected function initDoctrine() {
		$this->register(new Silex\Provider\DoctrineServiceProvider(), array(
			'db.options' => $this['config']->get('database'),
		));
	}

	protected function initLogging() {
		$this->register(new Silex\Provider\VarDumperServiceProvider());

		$this->register(new Silex\Provider\MonologServiceProvider(), array(
			'monolog.logfile' => __DIR__ . '/../../logs/development.log',
			'monolog.level' => $this['config']->get('log_level')
		));
	}

	protected function initLocales() {
		$this->register(new Silex\Provider\LocaleServiceProvider());
		$this->register(new Silex\Provider\TranslationServiceProvider(), array(
    		'translator.domains' => array(),
		));
	}

	protected function initForms() {
		$this->register(new Silex\Provider\FormServiceProvider());
		$this->register(new Silex\Provider\ValidatorServiceProvider());

		$template = $this['config']->get('form_templates');
		if ($template) {
			$this['twig.form.templates'] = $template;
		}
	}

	protected function initAssets() {
		$this->register(new Silex\Provider\AssetServiceProvider(), array(
			'assets.version' => $this['config']->get('assets_version'),
			'assets.version_format' => '%s?version=%s'
		));
	}

	protected function initSwiftmailer() {
		if ($config = $this['config']->get('mailer')) {
			$this->register(new Silex\Provider\SwiftmailerServiceProvider());

			$this['swiftmailer.options'] = $config;
		}
	}

	protected function initControllers() {
		/* Mount points */
		$controllers = $this['config']->get('router/mountpoints', []);
		foreach ($controllers as $name => $controller) {
			$this->mount($controller['path'], new $controller['controller']());
		}

		/* Individual routes */
		$routes = $this['config']->get('router/routes', []);
		foreach ($routes as $name => $info) {
			$method = isset($info['method']) ? $info['method'] : 'match';
			$route = $this->$method($info['path'], $info['controller']);
			if (isset($info['asserts'])) {
				foreach ($info['asserts'] as $var => $regex) {
					$route->assert($var, $regex);
				}
			}
			if (isset($info['defaults'])) {
				foreach ($info['defaults'] as $var => $val) {
					$route->value($var, $val);
				}
			}
			$route->bind($name);
        }
	}

	public function errorHandler(\Exception $exception) {
		if ($this['debug']) {
			return;
		}

		$this['monolog']->addError('Application Error: ' . $exception->getMessage());

		return $this['twig']->render('pages/error.html.twig', array(
			'message' => $exception->getMessage(),
			'code'    => $exception->getCode(),
			'trace'   => $exception->getTraceAsString(),
			'class'   => get_class($exception)
		));
	}
}
