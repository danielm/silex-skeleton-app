<?php

namespace App\Controller;

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

class Wellcome
{
	public static function index(Request $request, Application $app)
	{
		$app['monolog']->addDebug('Showing our homepage.');

		return $app['twig']->render('wellcome/index.html');
	}

	public static function rand(Request $request, Application $app, $max)
	{
		$number = rand(1, $max);

		$app['monolog']->addDebug("Randomizer 1-$max: $number");

		return $app['twig']->render('wellcome/rand.html', array(
			"max" => $max,
			"number" => $number
		));
	}
}
