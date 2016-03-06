<?php
/**
 * MemcachedProvider.php - Silex Skeleton Application
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
