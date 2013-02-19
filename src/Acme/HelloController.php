<?php

namespace Acme;

class HelloController
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function indexAction($name)
    {
        return $this->app['twig']->render('hello/index.twig', array(
            'name' => $name,
        ));
    }
}

