<?php

namespace Acme;

class SampleController
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function indexAction($name)
    {
        return $this->app['twig']->render('hello.twig', array(
            'name' => $name,
        ));
    }
}

