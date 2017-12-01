<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateBillTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_test_create_bill()
    {
        Bill::createNew([
            'owner' => 1,
            'description' => 'dinner',
            'cost' => 1000,
            'group_id' => 2
        ]);
        //Todo: add group and user in output
        $entry = Bill::first();
        $this->assertNotNull($entry);
    }
}
