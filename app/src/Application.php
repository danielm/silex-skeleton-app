<?php

namespace App;

use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Silex;
use App;

class Application extends Silex\Application {

	public function initBackend() {
		$this->initConfig();

		$this['debug'] = $this['config']->get('debug');
		if ($this['debug']) {
			\error_reporting(E_ALL);
			\ini_set('display_errors', '1');
		}

		$timezone = $this['config']->get('timezone');
		if ($timezone) {
			\date_default_timezone_set($timezone);
		}

		if ($this['config']->get('memcached')){
			$this->initCache();
		}
		$this->initTwig();
		$this->initDoctrine();
		$this->initSession();
		$this->initLogging();
		$this->initForms();
		$this->initAssets();
		$this->initSwiftmailer();

		$this->get('/', function () {
			return $this['twig']->render('pages/home.html.twig');
		});
	}

	protected function initConfig() {
		$this->register(new App\Provider\ConfigProvider('config'), array(
			'config.file' => __DIR__ . '/../../config/general.yml'
		));
	}

	protected function initCache() {
		$this->register(new App\Provider\MemcachedProvider(), array(
			'memcached.options' => $this['config']->get('memcached')
		));
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

	protected function initForms() {
		$this->register(new Silex\Provider\FormServiceProvider());
		$this->register(new Silex\Provider\ValidatorServiceProvider());

		$this['twig.form.templates'] = $this['config']->get('form_templates');
	}

	protected function initAssets() {
		$this->register(new Silex\Provider\AssetServiceProvider(), array(
			'assets.version' => $this['config']->get('assets_version'),
			'assets.version_format' => '%s?version=%s'
		));
	}

	protected function initSwiftmailer() {
		$this->register(new Silex\Provider\SwiftmailerServiceProvider());

		$this['swiftmailer.options'] = $this['config']->get('mailer');
	}

}
