<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function tests_if_user_is_entry()
    {
         User::entryNew([
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
        $findUser = User::findWith(['telegram_id' => $fakeUser->telegram_id]);
        $this->assertEquals($fakeUser->telegram_id,$findUser->telegram_id);
    }
}
