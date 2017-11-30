<?php

namespace Tests\Feature;

use App\Ledger;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LedgerCreateTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_tests_creating_multiple_row()
    {
        $array = [
            ['creditor' =>  1, 'owe' => 2, 'amount' => 142244],
            ['creditor' =>  1, 'owe' => 2, 'amount' => 142244],
            ['creditor' =>  4, 'owe' => 3, 'amount' => 15262],
        ];
        Ledger::storeRow($array);
        $this->assertCount(3,Ledger::all());
    }
}
