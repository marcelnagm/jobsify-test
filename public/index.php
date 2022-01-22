<?php

declare(strict_types=1);
ini_set(‘display_errors’, '1');
        
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;
use Slim\App;
use App\Utility\Configuration;
use Illuminate\Database\Capsule\Manager;
use App\Middleware\Auth;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$ENV = $_ENV['ENV'] ?? 'dev';

$containerBuilder = new ContainerBuilder();

// Import services
$dependencies = require __DIR__ . '/../app/services.php';
$dependencies($containerBuilder);

// Initialize app with PHP-DI
$container = $containerBuilder->build();
AppFactory::setContainer($container);

$app = AppFactory::create();

//require __DIR__ . '/../app/eloquent.php';

$container = $app->getContainer();
// $container->set('db',$capsule);
// var_dump($container->get('db')) ;
 
// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);


// Setup Basic Auth
$auth = require __DIR__ . '/../app/auth.php';
$auth($app,$container);

$displayErrorDetails = $ENV == 'dev';
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);

// Error Handler
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');


$container = $app->getContainer();

$app->run();
