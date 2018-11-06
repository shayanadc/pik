<?php

namespace Tests\Feature;

use App\Group;
use App\User;
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
    //Todo: test unique col with c_id and name
    public function it_create_group_and_assign_creator()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', 'api/groups', ['name' => 'Before Fri', 'creator_id' => $user->id]);
        $group = Group::where('name', 'Before Fri')->first();
        $this->assertEquals('Before Fri', $group->name);
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Before Fri'
            ]);
    }
    /**
     * @test
     *
     */
    public function it_returns_group_of_user(){
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        factory(Group::class,3)->create();
        $group->users()->sync([$user->id]);
        $response = $this->json('GET', 'api/groups/user/' . $user->id );
        $response
            ->assertStatus(200)
            ->assertJson([[
                'name' => $group->name
            ]
            ]);
    }
    /**
     * @test
     *
     */
    public function it_returns_user_of_group(){
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        factory(Group::class,3)->create();
        $group->users()->sync([$user->id]);
        $response = $this->json('GET', 'api/groups/'. $group->id );
        $group = Group::with('users')->find($group->id);
        $response
            ->assertStatus(200)
            ->assertJson(
                $group->toArray()
            );
    }
}
