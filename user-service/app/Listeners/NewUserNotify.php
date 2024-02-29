<?php

namespace App\Listeners;

use App\Events\NewUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use \App\Services\RabbitMQService;

class NewUserNotify
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewUser $event): void
    {
        $user = $event->user;
        $RMQService = new RabbitMQService();
        $RMQService->publish(json_encode($user));
    }
}
