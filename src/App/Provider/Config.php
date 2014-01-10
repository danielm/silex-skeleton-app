<?php
/**
 * Config.php - Our configuration provider
 * 
 * LICENSE: This source file is distributed under the MIT licence terms.
 * Read the MIT-LICENSE.txt file for details.
 *
 * @package    Silex Skeleton Application
 * @author     Daniel Morales <daniminas@gmail.com>
 * @copyright  2013-2014 Daniel Morales
 * @license    http://www.daniel.com.uy/doc/license/ MIT
 * @version    GIT: $Id$
 * @link       http://github.com/danielm/silex-skeleton-app
 */

namespace App\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use App\JsonFile;

class Config implements ServiceProviderInterface {

    public function register(Application $app) {
        $app['config'] = $app->share(function ($app) {
            $path = __DIR__ . '/../../../data/config.json';

            $config = new JsonFile($path);
            return $config;
        });
    }

    public function boot(Application $app) {
        
    }

}
