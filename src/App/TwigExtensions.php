<?php
/**
 * TwigExtensions.php - Our custom Twig functions and filters
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

namespace App;

class TwigExtensions extends \Twig_Extension {

    protected $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function getName() {
        return "appextensions";
    }

    public function getFunctions() {
        return array(
            "asset" => new \Twig_Function_Method($this, 'asset')
        );
    }

    public function asset($asset) {
        $assetsConfig = $this->app['config']->getSection('assets');
        if (!$assetsConfig) {
            return $asset;
        }

        return sprintf(rtrim($assetsConfig['path'], '/') . '/%s?v=%s', ltrim($asset, '/'), $assetsConfig['version']);
    }

    /* public function getFilters() {
      return array(
      "test"        => new \Twig_Filter_Method($this, "test"),
      );
      }

      public function test($input) {
      return "yay";
      } */
}
