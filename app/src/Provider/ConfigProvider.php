<?php
/**
 * ConfigProvider.php - Silex Skeleton Application
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
