<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Model\Quote;


class HistoryController
{
 
     private $container;

   // constructor receives container instance
   public function __construct(ContainerInterface $container)
   {
       $this->container = $container;
   }

    
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function view(Request $request, Response $response, $args ): Response
    {
        
//        $this->logger->addInfo('Something interesting happened');
        
        
        $this->container->get('db');
//        $user = new User();
//        $user->name='teste';
//        $user->user='teste';
//        $user->pass='teste';
//        $user->save();
        
        $result = Quote::where('user_id',1)->orderBy('created_at','desc')->get()->toArray();
        
        $result = json_encode($result);
//        $name = $args['id'];
//        $body = "Hello, $name";
//        
        
        $response->getBody()->write($result);
        
        return $response;
    }
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function store(Request $request, Response $response, $args ): Response
    {
//        
        $parsedBody =  json_decode($request->getBody()->getContents(), true);
        $this->container->get('db');
        $user = new User();
        $user->name=$parsedBody['name'];
        $user->user=$parsedBody['user'];
        $user->pass=$parsedBody['pass'];
        $user->save();
//        var_dump($parsedBody);
        
        #var_dump ($request);
//        $this->logger->addInfo('Something interesting happened');
//        $id = $args['id'];
//        $result = $this->container->get('db')->table('users')->find ($id);
//        var_dump($result);
//        $name = $args['id'];
        $body = "Hello do";
        
        
        $response->getBody()->write($body);
        
        return $response;
    }
    
    public function hello(Request $request, Response $response, $args ): Response
    {
        
//        $this->logger->addInfo('Something interesting happened');
//        var_dump ($this->container->get('db'));
        $id = $args['id'];
        $result = $this->container->get('db')->table('users')->find ($id);
        var_dump($result);
        $id = $args['id'];
        $body = "Hello, $name";
        
        
        $response->getBody()->write($body);
        
        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function bye(Request $request, Response $response, array $args): Response
    {
        $name = $args['name'];
        $body = "Bye, $name";

        $response->getBody()->write($body);

        return $response;
    }
}
