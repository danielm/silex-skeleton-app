<?php

namespace App\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use App\JsonFile;

class Config implements ServiceProviderInterface
{
    public function register(Application $app){
        $app['config'] = $app->share(function ($app) {
        	$path = __DIR__ . '/../../../data/config.json';

            $config = new JsonFile($path);
            return $config;
        });

    }

    public function boot(Application $app)
    {
    }
}
