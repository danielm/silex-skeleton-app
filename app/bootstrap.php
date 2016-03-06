<?php
/**
 * bootstrap.php - Silex Skeleton Application
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
if (version_compare(PHP_VERSION, '5.5.9', '<')) {
	echo "Your PHP Version is not supported";

	exit(1);
}

if (PHP_SAPI === 'cli-server') {
	if (is_file($_SERVER['DOCUMENT_ROOT'] . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']))) {
		return false;
	}
}

require_once __DIR__ . '/../vendor/autoload.php';

$app = new App\Application();
return $app;

