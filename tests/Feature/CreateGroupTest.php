<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

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
        $newGroup = App\Group::mekeNew($groupName);
        $this->seeInDatabase('groups',['name' => $groupName]);
    }
}
