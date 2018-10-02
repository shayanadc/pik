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
    //Todo: complete this test
    public function it_returns_user_after_find()
    {
        factory(User::class)->create(['username' => 42151,'name' => 'Sally','surname' => 'Dock']);
        $response = $this->json('POST', 'api/users', ['name' => 'Sally','username' => 42151]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'username' => 42151,
                'name' => 'Sally',
                'surname' => 'Dock'
            ]);
    }
    /**
     * @test
     */
    public function it_assign_users_to_specific_group_and_return_group_with_users(){
        $group = factory(Group::class)->create();
        factory(User::class,3)->create();
        $group = Group::find($group->id);
        $this->assertCount(0,$group->users);
        $response = $this->json('POST', 'api/users/group', ['group_id' => $group->id, 'users_id' => [1,2,3]]);
        $group = Group::find($group->id);
        $this->assertCount(3,$group->users);
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $group->name
                ]);
    }
}
