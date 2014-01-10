<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();

// Load our Configuration
$app->register(new App\Provider\Config());

// Timezone
$timezone = $app['config']->getSection('timezone');
if($timezone){
    date_default_timezone_set($timezone);
}

// Views and Helpers
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app["twig"] = $app->share($app->extend("twig", function (\Twig_Environment $twig, Silex\Application $app) {
    $twig->addExtension(new App\TwigExtensions($app));

    return $twig;
}));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Debug
$app['debug'] = $app['config']->getSection('debug');
if($app['debug']){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Database Connection
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app['config']->getSection('database')
));

// Logging
$logging = $app['config']->getSection('log');
$app->register(new Silex\Provider\MonologServiceProvider(), array(
   	'monolog.logfile' => __DIR__ . $logging['file'],
   	'monolog.level' => $logging['level']
));

// Error handling
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    $app['monolog']->addError('Application Error: ' . $e->getMessage());
    
    return $app['twig']->render('errors/application.html', array(
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ));
});

// Router will load/handle all our routes. See the Config section for more.
$app->mount('', new App\Router());

// Shazam!
$app->run();
