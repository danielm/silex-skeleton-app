#Silex Skeleton Application
Base Silex Application (skeleton) to get a new project going and organize the code (my approach)

Distributed under the MIT license.
Created by Daniel Morales. [Contact Me](mailto:daniminas@gmail.com) for more info or anything you want :)

##Install
```
$ git clone http://github.com/danielm/silex-skeleton-app
$ cd silex-skeleton-app
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

##Basics

###Configuration Files
* ```config/general.yml```: Basic configuration vars. Use ```$app['config']->get('varName')```  on your controllers to access your custom configuration variables.

###Controllers
```src/App/Controller/*.php```: Check ```config/general.yml``` out to map routes/controllers.

###Views
```views/*.html.twig```: Designers corner

###Custom Twig Extensions (Functions and Filters)
```src/App/TwigExtensions.php``` Basic extension to add custom Twig functions and filters.

