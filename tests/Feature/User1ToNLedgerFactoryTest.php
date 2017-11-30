<?php

namespace Tests\Feature;

use App\Bill;
use App\Ledger;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class User1ToNLedgerFactoryTest extends TestCase
{
    use  DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_returns_creditor_or_owe_user_of_ledger()
    {
        $ledger = factory(Ledger::class)->create();
        $ledger = Ledger::find($ledger->id);

        $creditor = User::find($ledger->creditor);
        $owe = User::find($ledger->owe);
        $this->assertEquals($creditor->id,$ledger->creditorUser->id);
        $this->assertEquals($owe->id,$ledger->oweUser->id);
    }
}
