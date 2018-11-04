<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function tests_if_user_is_entry()
    {
         User::findOrMakeNewByUsername([
            'name' => 'shayanadc',
            'username' => 11523526
        ]);
        $newUser = User::first();
        $this->assertNotNull($newUser);
    }

    /**
     * @test
     */
    public function it_find_user_base_array(){
        $fakeUser = factory(User::class)->create();
        $findUser = User::findOrMakeNewByUsername(['username' => $fakeUser->username, 'name' => 'AJO']);
        $this->assertEquals($fakeUser->id,$findUser->id);
    }
}
