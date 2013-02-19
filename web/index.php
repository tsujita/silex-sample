<?php

require_once __DIR__.'/../vendor/autoload.php';

use Acme\HelloController;

$app = new Silex\Application(); 

$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../logs/development.log',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('homepage.twig');
})
->bind('homepage');

$app['hello.controller'] = $app->share(function () use ($app) {
    return new HelloController($app);
});

$app->get('/hello/{name}', 'hello.controller:indexAction')->bind('hello');;

$app['monolog']->addDebug('Testing the Monolog logging.');

$app->run(); 

