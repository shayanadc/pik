<?php

namespace Tests\Feature;

use App\Group;
use App\UserGroupBoundary;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGroupBoundaryTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    //Todo : test one user to one or more group
    public function it_adds_users_to_specific_group()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $this->assertCount(0,$group->users);
        UserGroupBoundary::addUsersToGroup($group->id,[$user2->id,$user1->id]);
        $group = Group::find($group->id);
        $this->assertCount(2,$group->users);
    }
}
