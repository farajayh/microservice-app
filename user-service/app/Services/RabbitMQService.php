<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Message\AMQPMessage;

use Illuminate\Support\Facades\Log;

class RabbitMQService
{
    private $connection;
    private $channel;


    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(env('RMQ_HOST'), env('RMQ_PORT'), env('RMQ_USER'), env('RMQ_PASS'), env('RMQ_VHOST'));
        $this->channel = $this->connection->channel();
    }


    public function publish($message)
    {
        $this->channel->exchange_declare('microserv-app', 'direct', false, false, false);
        $this->channel->queue_declare('user-notifications', false, false, false, false);
        $this->channel->queue_bind('user-notifications', 'microserv-app', 'test_key');
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, 'microserv-app', 'test_key');
        $this->channel->close();
        $this->connection->close();
    }


    public function consume()
    {
        $callback = function ($msg) {
            echo "New Notification Received.\n";
            Log::channel('user-notification')->info("New User Data: $msg->body");
        };

        $this->channel->queue_declare('user-notifications', false, false, false, false);
        $this->channel->basic_consume('user-notifications', '', false, true, false, false, $callback);
        
        echo "Ready... \n";
        
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }
}