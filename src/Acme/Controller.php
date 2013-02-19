<?php

namespace Acme;

class Controller
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        return $this->app['twig']->render($view, $parameters, $response);
    }

    protected function get($name)
    {
        return $this->app[$name];
    }
}

