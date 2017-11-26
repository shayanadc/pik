<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Group;

class CreateGroupTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     * @test
     * @return void
     */

    public function it_tests_create_new_group(){
        $groupName = '15-9-26';
        $newGroup = Group::entryNew($groupName);
        $entry = Group::first();
        $this->assertNotNull($entry);
    }
}
