<?php

namespace App;

class TwigExtensions extends \Twig_Extension
{
    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function getName(){
        return "appextensions";
    }

    public function getFunctions(){
        return array(
            "asset" => new \Twig_Function_Method($this, 'asset')
        );
    }

    public function asset($asset){
        $assetsConfig = $this->app['config']->getSection('assets');
        if(!$assetsConfig){
            return $asset;
        }

        return sprintf(rtrim($assetsConfig['path'], '/') . '/%s?v=%s', ltrim($asset, '/'), $assetsConfig['version']);
    }

    /*public function getFilters() {
        return array(
            "test"        => new \Twig_Filter_Method($this, "test"),
        );
    }

    public function test($input) {
        return "yay";
    }*/
}