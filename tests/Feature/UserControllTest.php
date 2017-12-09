<?php

namespace Tests\Feature;

use App\Group;
use App\User;
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
    /**
     * @test
     */
    public function it_assign_users_to_specific_group_and_return_group_with_users(){
        $group = factory(Group::class)->create();
        $users = factory(User::class,3)->create();
        $response = $this->json('POST', 'api/users/group', ['group_id' => $group->id, 'users_id' => [1,2,3]]);
        $this->assertCount(3,$group->users);
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $group->name
                ]);
    }
}
