<?php

require 'vendor/autoload.php';

define('ROOT', __DIR__);
define('ROOT_API', '/var/kinoulink/api');

use Symfony\Component\Filesystem\Filesystem;

$app = new \Slim\Slim();

$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

$app->get('/releases', function () use ($app)
{
    $buffer = [];

    foreach(glob(ROOT_API . '/*') as $file)
    {
        $buffer []= trim(str_replace(ROOT_API, '', $file), '/');
    }

    return $app->render(200, [
        'data' => $buffer
    ]);
});

$app->get('/deploy', function () use ($app)
{

});

$app->get('/', function() use ($app)
{
    return $app->render(200, [
        'author'    => 'Kinoulink',
        'name'      => 'CI Server',
        'version'   => '1'
    ]);
});

$app->run();