
<?php

use Slim\App;
use App\Utility\Configuration;
use Illuminate\Database\Capsule\Manager;

return static function () {

    $dbSettings = [
        'driver' => 'mysql', 
        'host' => $_ENV["DB_HOST"], 
        'port' => $_ENV["DB_PORT"], 
        'database' => $_ENV["DB_NAME"], 
        'username' => $_ENV["DB_USER"], 
        'password' => $_ENV["DB_PASSWORD"], 
        'charset' => $_ENV["DB_CHARSET"], 
        'collation' => $_ENV["DB_COLLATION"]
    ];

    // boot eloquent
      $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
    
};


