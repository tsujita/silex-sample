<?php

require_once __DIR__.'/../vendor/autoload.php';

class MyApplication extends Silex\Application {
    use Silex\Application\UrlGeneratorTrait;
    use Silex\Application\TwigTrait;
    use Silex\Application\MonologTrait;
}

$app = new MyApplication(); 

$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__.'/../db.sqlite',
    ),
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../logs/development.log',
));

$app->register($profiler = new Silex\Provider\WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../cache/profiler',
));
$app->mount('/_profiler', $profiler);

//
// ServiceControllerテスト
//

$app['sample.controller'] = $app->share(function () use ($app) {
    return new Acme\SampleController($app);
});
$app->get('/hello/{name}', 'sample.controller:indexAction')->bind('hello');

//
// Doctrineテスト
//

$app->get('/dbal/', function () use ($app) {
    return $app->render('/dbal/index.twig');
})
->bind('dbal_index');

$app->get('/dbal/select', function () use ($app) {
    $stmt = $app['db']->prepare("SELECT * FROM `user`");
    $stmt->execute();
    return $app->render('/dbal/select.twig', array(
        'users' => $stmt->fetchAll(),
    ));
})
->bind('dbal_select');

$app->get('/dbal/insert/{name}', function ($name) use ($app) {
    $stmt = $app['db']->prepare("INSERT INTO `user` (`name`) VALUES (?)");
    $stmt->execute(array($name));
    return $app->redirect($app->path('dbal_select'));
})
->bind('dbal_insert');

$app->get('/dbal/delete', function () use ($app) {
    $stmt = $app['db']->prepare("DELETE FROM `user`");
    $stmt->execute();
    return $app->redirect($app->path('dbal_select'));
})
->bind('dbal_delete');

$app->get('/dbal/truncate', function () use ($app) {
    $stmt = $app['db']->prepare("TRUNCATE TABLE `user`");
    $stmt->execute();
    return $app->redirect($app->path('dbal_select'));
})
->bind('dbal_truncate');

//
// Monologテスト
//

$app['monolog']->debug('Testing the Monolog logging.');
$app['monolog']->info('Testing the Monolog logging.');
$app['monolog']->notice('Testing the Monolog logging.');
$app['monolog']->warn('Testing the Monolog logging.');
$app['monolog']->err('Testing the Monolog logging.');
$app['monolog']->crit('Testing the Monolog logging.');
$app['monolog']->alert('Testing the Monolog logging.');
$app['monolog']->emerg('Testing the Monolog logging.');

$app->run(); 

