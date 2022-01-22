<?php

namespace App\Middleware;

use Jweety\Encoder;
use App\Model\User;
use Slim\Exception\HttpUnauthorizedException;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author marcel
 */
class Auth {

    //put your code here

    private $container;
    private $app;

    public function __construct($container,$app) {
        $this->container = $container;
        $this->app= $app;
        
    }

    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke( $request, $handler) {
        // $this->container has the DI
        $publicRoutesArray = array(
            '/login',
            '/register',
        );

        $protectedRoutesArray = array(
            '/users/',
            '/history',
            '/stock',
        );
        $encoder = new \Jweety\Encoder($_ENV["JWT_PASSWORD"]);
//        var_dump($encoder);
        $data = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoidGVzdCIsInBhc3MiOiJ0ZXN0aW5nIn0.ugfrZnQ4XwBS9fL9krNlgVuOP7Ag6jAgWE673zukfCE';
        $jwt = (array) $encoder->parse($data, $_ENV["JWT_PASSWORD"]);

// After JWT is decoded successfully, now you can retrieve claims
//        $user = (array)$jwt; // Equals 'John Doe'
//        $pass = (array)$jwt->getClaim('pass'); // Equals 1234567890

        var_dump($jwt);
        var_dump($request->getURI()->getPath());

        if (in_array($request->getURI()->getPath(), $protectedRoutesArray)) {
            $this->container->get('db');
            $result = User::where('user', $jwt['user'])->
                            where('pass',md5($jwt["pass"]))->first();
            var_dump($result);
//            var_dump($result);

            if ($result == NULL) {
                throw new HttpUnauthorizedException($request);
            } else {
                session_start();
                                 $_SESSION['USER'] = $result;
                
            }
        }

        if (!isset($_SESSION['USER'])) {
            throw new Exception('No Session');
        }
//        

        $response = $handler->handle($request);
        $statusCode = $response->getStatusCode();
         
        if ($statusCode == 401) {
            throw new HttpUnauthorizedException($request);
        }

        return $response;
    }

}
