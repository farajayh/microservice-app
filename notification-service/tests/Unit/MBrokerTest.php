<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RabbitMQService;

class MBrokerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Check that the broker can be connected to
     */
    public function test_broker_can_be_reached(): void
    {
        $RMQService = new RabbitMQService();
        $this->assertTrue($RMQService->connected);
    }
}
