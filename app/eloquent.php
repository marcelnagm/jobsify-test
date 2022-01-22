
<?php

require __DIR__. '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Manager;

return function ( ){

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
    $capsule = new Manager();
    $capsule->addConnection($dbSettings);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    
    return $capsule;
};


