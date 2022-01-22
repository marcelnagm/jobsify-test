<?php

declare(strict_types=1);

use Slim\App;
use Slim\Exception\HttpUnauthorizedException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Tuupola\Middleware\HttpBasicAuthentication;
use Jweety\Encoder;
use App\Middleware\Auth;

require "../src/Midleware/Auth.php";


return function (App $app) {
   
    $username = $_ENV["ADMIN_USERNAME"] ?? 'root';
    $password = $_ENV["ADMIN_PASSWORD"] ?? 'secret';




    // 1st middleware to configure basic authentication
    $container = $app->getContainer();
    $app->add(new Auth($container,$app));
    
    // 2nd middleware to throw 401 with correct slim exception
    // Reformat when lin updates to v4, see: https://github.com/tuupola/slim-basic-auth/issues/95
   
};
