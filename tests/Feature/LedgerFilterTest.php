<?php

namespace Tests\Feature;

use App\Bill;
use App\Group;
use App\Ledger;
use App\LedgerBoundary;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LedgerFilterTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function testLedgerRequestFilter()
    {
        $myUser = factory(User::class)->create();
        $myGroup = factory(Group::class)->create();
        $group2 = factory(Group::class)->create();
        $myBill = factory(Bill::class)->create(['group_id' => $myGroup->id]);
        $bill2 = factory(Bill::class)->create(['group_id' => $group2->id]);
        $f1 = factory(Ledger::class)->create([
            'bill_no' =>  $myBill->id,
            'creditor' => $myUser->id,
            'owe' => factory(User::class)->create()->id
        ]);
        $f2 = factory(Ledger::class)->create([
            'bill_no' =>  $myBill->id,
            'owe' => $myUser->id,
            'creditor' => factory(User::class)->create()->id
        ]);
        $f3 = factory(Ledger::class)->create([
            'bill_no' =>  $bill2->id,
            'owe' => $myUser->id,
            'creditor' => factory(User::class)->create()->id
        ]);
        factory(Ledger::class)->create([
            'bill_no' =>  $myBill->id,
            'creditor' => factory(User::class)->create()->id,
            'owe' => factory(User::class)->create()->id
        ]);
        $ledgers = LedgerBoundary::filterBy($myUser->id,$myGroup->id)->pluck('id')->toArray();
        $this->assertEquals([$f1->id,$f2->id], $ledgers);
        $ledgers = LedgerBoundary::filterBy($myUser->id)->pluck('id')->toArray();
        $this->assertEquals([$f1->id,$f2->id,$f3->id], $ledgers);
    }
}
