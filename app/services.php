<?php
declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
      $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
             'displayErrorDetails' => true,
        ],
       'db' => require 'eloquent.php' ,
       'mailer' => require 'mailer.php' ,
       'logger' => require 'logger.php' ,
    ]);
};
