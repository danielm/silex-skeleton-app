<?php
/**
 * Test.php - Silex Skeleton Application
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
namespace App\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Test {

    public static function rand(Request $request, Application $app, $max) {
        $number = rand(1, $max);

        return $app['twig']->render('pages/rand.html.twig', array(
            "max" => $max,
            "number" => $number
        ));
    }

    public static function form(Request $request, Application $app) {
        $form = $app['form.factory']->createBuilder('form', [])
				->add('email', 'email')
				->add('password', 'password')
				->add('checkbox', 'checkbox')
				->add('textarea', 'textarea')
				->add('choice', 'choice', [
					'choices' => [
						'morning'   => 'Morning',
						'afternoon' => 'Afternoon',
						'evening'   => 'Evening'
					]
				])
				->add('date', 'date', [
					'input'  => 'timestamp',
					'widget' => 'choice',
				])
				->add('choice', 'choice', [
					'choices' => [
						'yes'   => 'Yes',
						'no'    => 'No',
						'maybe' => 'Maybe'
					],
					'expanded' => true
				])
				->add('send', 'submit')
				->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
			$data = $form->getData();

			// Do something
		}

        return $app['twig']->render('pages/form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}