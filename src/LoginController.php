<?php

declare(strict_types=1);

namespace App;

require __DIR__. '/../vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use GuzzleHttp\Client;
use App\Model\Quote;

class LoginController {

    private $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function log(Request $request, Response $response, $args): Response {
        
        
       
        $body = "Processed request of $name by user_id ";
//
//
        $response->getBody()->write($body);

        return $response;
    }

}
