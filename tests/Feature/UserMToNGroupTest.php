<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserMToNGroupTest extends TestCase
{
    use DatabaseMigrations;

    protected $group1;
    protected $group2;
    protected $user1;
    protected $user2;

    public function fixtureSetup()
    {
        $this->group1 = factory(Group::class,5)->create();
        $this->group2 = factory(Group::class,4)->create();

        $this->user1 = factory(User::class)->create();
        $this->user2 = factory(User::class)->create();
        $this->user3 = factory(User::class)->create();

    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_returns_groups_of_user()
    {
        $this->fixtureSetup();
        $this->user1->groups()->sync($this->group1->pluck('id')->all());
        $this->user2->groups()->sync($this->group2->pluck('id')->all());
        $this->assertEquals($this->group1->pluck('id')->all(), $this->user1->groups->pluck('id')->all());
        $this->assertEquals($this->group2->pluck('id')->all(), $this->user2->groups->pluck('id')->all());
    }
    /**
     * @test
     */
    public function it_returns_users_of_an_group()
    {
        $this->fixtureSetup();

        $group1 = $this->group1->first();
        $group2 = $this->group2->first();

        $group1->users()->sync([$this->user1->id, $this->user2->id]);
        $group2->users()->sync([$this->user2->id]);

        $this->assertEquals([$this->user1->id, $this->user2->id], $group1->users->pluck('id')->all());
    }
}
