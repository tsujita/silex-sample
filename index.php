<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application(); 

$app['debug'] = true;

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->get('/', function () {
    return 'welcome to the homepage';
})
->bind('homepage');

$app->get('/hello/{name}', function($name) use($app) { 
    return $app['twig']->render('hello.twig', array(
        'name' => $name,
    ));
})
->bind('hello'); 

$app->run(); 

