#Silex Skeleton Application
Base Silex Application (skeleton) to get a new project going and organize the code (my approach)

Distributed under the MIT license.
Created by Daniel Morales. [Contact Me](mailto:daniminas@gmail.com) for more info or anything you want :)

##Install
```
$ git clone http://github.com/danielm/silex-skeleton-app
$ cd silex-skeleton-app
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar update
$ php -S localhost:8080
```

##Basics

###Configuration Files
* ```data/config.json```: Basic configuration vars. Use ```$app['config']->getSection('varName')```  on your controllers to access your custom configuration variables.
* ```data/routes.json```: Simple router configuration. 

###Controllers
```src/App/Controller/*.php```: Check ```data/routes.json``` out to map routes/controllers.

###Views
```views/*.html```: Designers corner

###Custom Twig Extensions (Functions and Filters)
```src/App/TwigExtensions.php``` As example I included one asset extension. Use ```{{ asset('/css/app.main.css') }}``` on your views to get a url-safe and versioned path for your assets.

