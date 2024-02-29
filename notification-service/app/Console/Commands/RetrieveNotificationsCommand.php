<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\RabbitMQService;

class RetrieveNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retrieve-notifications-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve notifications from RabbitMQ service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $RMQService = new RabbitMQService();
        $RMQService->consume();
    }
}
