<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }


    /**
     * Test successful creation of a user.
     *
     * @return void
     */
    public function test_can_create_user()
    {
        $userData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $this->json('POST', 'api/user', $userData)
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Success',
        ]);            
    }

}
