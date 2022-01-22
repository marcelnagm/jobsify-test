<?php

declare(strict_types=1);

use App\HelloController;
use App\UserController;
use App\StockController;
use App\HistoryController;
use App\LoginController;
use Slim\App;

use Psr\Container\ContainerInterface;

return function (App $app) {
    // unprotected routes


$app->get('/users/{id}',UserController::class.':view');

$app->get('/history/',HistoryController::class.':view');

$app->post('/register',UserController::class.':store');

$app->post('/stock', StockController::class.':retrieve');

$app->post('/login', LoginController::class.':log');

    // protected routes


};
