<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_returns_user_after_find_or_create()
    {
        $response = $this->json('POST', 'api/users', ['name' => 'Sally','telegram_id' => 42151]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'telegram_id' => 42151,
                'name' => 'Sally'
            ]);
    }
}
