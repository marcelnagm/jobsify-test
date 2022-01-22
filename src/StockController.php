<?php

declare(strict_types=1);

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use GuzzleHttp\Client;
use App\Model\Quote;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class StockController {

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
    public function retrieve(Request $request, Response $response, $args): Response {

        $name = $request->getQueryParams()['name'];
        if ($name == '') {
//        var_dump();
//          $name = $args['name'];
            $body = 'Error 500 - You should send the stock name';
            $response->getBody()->write($body);

            return $response;
        }

        $url = 'https://stooq.com/q/l/';
        $stock = '?s=' . $name;
        $extra = '&f=sd2t2ohlcvn&h&e=json';

//        echo $url . $stock . $extra;
        $client = new Client([
            'base_uri' => $url . $stock . $extra,
        ]);

        $resp = $client->request('GET');

//        var_dump($response) ;
//
////        var_dump ($this->container->get('db'));
          var_dump (session_status());
        $data = (array) json_decode($resp->getBody() . '');
        $this->container->get('db');
        $quote = new Quote((array) $data['symbols'][0]);
//        var_dump ($_SESSION);
        $quote->user_id = $_SESSION['USER']->id;
//        $quote->user_id = 1;
        $quote->save();


        if ($_ENV["RMQ_ENABLED"]) {

            $msg = json_encode(array(
                'to' => 'john@doe.com',
                'subject' => 'QUOTE REQUEST - ' . $quote->name,
                'data' => $quote
            ));
            $this->publishMq($msg);
        } else {
            $sub = 'QUOTE REQUEST - ' . $quote->name;
            $mailer = $this->container->get('mailer');
            $message = (new \Swift_Message($sub))
                    ->setFrom(['john@doe.com' => 'John Doe'])
                    ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
                    ->setBody('Stock Quote ' . $quote)
            ;

// Send the message
            $result = $mailer->send($message);
        }
//        
//      
//        var_dump($mailer);
        $body = "Processed request of $name by user_id ";
//
//
        $response->getBody()->write($body);

        return $response;
    }

    public function publishMq($msg) {
        $exchange = 'router';
        $queue = 'msgs';

        $connection = new AMQPStreamConnection(
                $_ENV["RMQ_HOST"],
                $_ENV["RMQ_PORT"],
                $_ENV["RMQ_USERNAME"],
                $_ENV["RMQ_PASSWORD"],
                $_ENV["RMQ_VHOST"]);
        $channel = $connection->channel();

        /*
          The following code is the same both in the consumer and the producer.
          In this way we are sure we always have a queue to consume from and an
          exchange where to publish messages.
         */

        /*
          name: $queue
          passive: false
          durable: true // the queue will survive server restarts
          exclusive: false // the queue can be accessed in other channels
          auto_delete: false //the queue won't be deleted once the channel is closed.
         */
        $channel->queue_declare($queue, false, true, false, false);

        /*
          name: $exchange
          type: direct
          passive: false
          durable: true // the exchange will survive server restarts
          auto_delete: false //the exchange won't be deleted once the channel is closed.
         */

        $channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);

        $channel->queue_bind($queue, $exchange);

        $messageBody = $msg;
        $message = new AMQPMessage($messageBody, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($message, $exchange);

        $channel->close();
        $connection->close();
    }

}
