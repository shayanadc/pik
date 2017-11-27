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
         User::findOrMakeNew([
            'telegram_id' => 11523526,
            'telegram_username' => null
        ]);
        $newUser = User::first();
        $this->assertNotNull($newUser);
    }

    /**
     * @test
     */
    public function it_find_user_base_array(){
        $fakeUser = factory(User::class)->create();
        $findUser = User::findOrMakeNew(['telegram_id' => $fakeUser->telegram_id,'name' => $fakeUser->name]);
        $this->assertEquals($fakeUser->telegram_id,$findUser->telegram_id);
    }
}
