<?php

require __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Silex\Provider\TwigServiceProvider;


$app = new Application();
// For to true, will be override by config
$app['debug'] = true;

// ---------
// Providers
// ---------

// Config
$app->register(
 new GeckoPackages\Silex\Services\Config\ConfigServiceProvider(),
 array(
  'config.dir'    => __DIR__.'/../config',
  'config.format' => '%key%.yml',
  'config.env'    => 'dev',
  'config.cache'  => null,
  'config.root'   => __DIR__.'/..',
 )
);
$app['debug'] = $app['config']->get('config')['app']['debug'];

// Twig
$app->register(new TwigServiceProvider(), array('twig.path' => __DIR__.'/../src/View',));

// Helper
$helper = new Kl3sk\Controller\Tool\HelperController();

$app['routes'] = $app->extend(
 'routes',
 function (RouteCollection $routes) {
     $loader = new YamlFileLoader(new FileLocator(__DIR__.'/../config'));
     $collection = $loader->load('routes.yml');
     $routes->addCollection($collection);

     return $routes;
 }
);

$app->get(
 '/hello/{name}',
 function ($name) use ($app) {
     return $app['twig']->render(
      'hello.twig',
      array(
       'name' => $name,
      )
     );
 }
);

$app->get('/c', $helper->controller('Index:Default:index'));
$app->get('/m', $helper->controller('Tool:Dir:menu'));
$app->get('/tpl/an/other/deep/path/autoroute', $helper->controller('Index:Default:route'));

$app->run();
