<?php

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MemcachedProvider implements ServiceProviderInterface {

	public function register(Container $app) {
		$app['memcached'] = function($app) {
			$memcache = new \Memcached();

			if (!isset($app['memcached.options'])){
				$app['memcached.options'] = [];
			}
			
			if (isset($app['memcached.options']['servers'])) {
				foreach ($app['memcached.options']['servers'] as $server) {
					$memcache->addServer($server['host'], $server['port']);
				}
			} else {
				$memcache->addServer('127.0.0.1', 11211);
			}

			if (isset($app['memcached.options']['prefix']) && method_exists($memcache, 'setPrefix')) {
				$memcache->setPrefix($app['memcached.prefix']);
			}

			return $memcache;
		};
	}

}
