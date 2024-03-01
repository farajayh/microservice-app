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



    /**
     * Test that email is required
     *
     * @return void
     */
    public function test_email_is_required()
    {
        $userData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $this->json('POST', 'api/user', $userData)
            ->assertStatus(400);            
    }

    /**
     * Test that first name is required
     *
     * @return void
     */
    public function test_firstName_is_required()
    {
        $userData = [
            'email' => 'test@example.com',
            'lastName' => 'Doe',
        ];

        $this->json('POST', 'api/user', $userData)
            ->assertStatus(400);            
    }

    /**
     * Test that lastName is required
     *
     * @return void
     */
    public function test_lastName_is_required()
    {
        $userData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
        ];

        $this->json('POST', 'api/user', $userData)
            ->assertStatus(400);            
    }

}
