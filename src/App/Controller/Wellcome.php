<?php
/**
 * Wellcome.php - Simple application controller
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

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Wellcome {

    public static function index(Request $request, Application $app) {
        $app['monolog']->addDebug('Showing our homepage.');

        return $app['twig']->render('wellcome/index.html');
    }

    public static function rand(Request $request, Application $app, $max) {
        $number = rand(1, $max);

        $app['monolog']->addDebug("Randomizer 1-$max: $number");

        return $app['twig']->render('wellcome/rand.html', array(
                    "max" => $max,
                    "number" => $number
        ));
    }

}
