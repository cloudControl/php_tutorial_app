<?php

require_once __DIR__.'/../silex.phar';
require_once __DIR__.'/../_config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path'       => __DIR__.'/../views',
        'twig.class_path' => __DIR__.'/../vendor/twig/lib'
    )
);

$app->get('/', function() use ($app, $config) {
    # check MySQL connection
    $success = false;
    $conn = mysql_connect($config['MYSQL_HOSTNAME'],
        $config['MYSQL_USERNAME'],
        $config['MYSQL_PASSWORD']);
    if ($conn) {
        $success = true;
        mysql_close($conn);
    }
    $is_default = false;
    $parsed_dep_name = explode('/', $_SERVER["DEP_NAME"]);
    if ($parsed_dep_name[1] == 'default') {
        $is_default = true;
    }
    return $app['twig']->render('index.twig', array(
        'success' => $success,
        'dep_name' => $_SERVER["DEP_NAME"],
        'default' => $is_default
    ));
});

$app->run();

?>

