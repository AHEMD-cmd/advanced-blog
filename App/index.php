<?php

use System\Application;

$app = Application::getInstance();


$app->route->add('/', 'Home');
$app->route->add('/posts/:text/:id', 'posts/post');
$app->route->add('/404', 'Error/NotFound');
$app->route->notFound('/404');