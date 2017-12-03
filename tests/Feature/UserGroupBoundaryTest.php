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
    public function it_adds_users_to_specific_group()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $group = factory(Group::class)->create();
        UserGroupBoundary::addUsersToGroup($group->id,[$user2->id,$user1->id]);
        $this->assertCount(2,$group->users);
    }
}
