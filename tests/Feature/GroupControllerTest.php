<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_create_group_and_assign_creator()
    {
        $response = $this->json('POST', 'api/groups', ['group_name' => 'Before Fri','telegram_id' => 42151]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Before Fri'
            ]);
    }
}
