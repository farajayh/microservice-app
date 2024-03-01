<?php

namespace App\Services;

use Error;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Message\AMQPMessage;

use Illuminate\Support\Facades\Log;

class RabbitMQService
{
    private $connection;
    private $channel;

    public $connected = false;


    public function __construct()
    {
        try{
            $this->connection = new AMQPStreamConnection(env('RMQ_HOST'), env('RMQ_PORT'), env('RMQ_USER'), env('RMQ_PASS'), env('RMQ_VHOST'));
            $this->channel = $this->connection->channel();

            $this->connected = true;
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }


    public function publish($message)
    {
        if(!$this->connected) return false;

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
        if(!$this->connected) return false;

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