<?php

namespace Kl3sk\Controller\Index;

use Silex\Application;

class DefaultController
{
    public function indexAction(Application $app)
    {
       return $app['twig']->render("hello.twig", [
        'name' => 'ouep'
       ]);
    }
    
    public function routeAction(Application $app, $path)
    {
        return $app['twig']->render("{$path}.twig");
    }
}
