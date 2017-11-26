<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class CreateBillTest extends TestCase
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
}
