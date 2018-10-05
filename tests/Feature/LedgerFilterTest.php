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
     * @test
     */
    public function testLedgerRequestFilterBetween2people()
    {
        $myUser = factory(User::class)->create();
        $myFriend = factory(User::class)->create();
        $myGroup = factory(Group::class)->create();
        $group2 = factory(Group::class)->create();
        $bill1 = factory(Bill::class)->create(['group_id' => $myGroup->id]);
        $bill2 = factory(Bill::class)->create(['group_id' => $group2->id]);
        $f1 = factory(Ledger::class)->create([
            'bill_no' => $bill1->id,
            'creditor' => $myUser->id,
            'owe' => $myFriend->id
        ]);
        $f2 = factory(Ledger::class)->create([
            'bill_no' => $bill1->id,
            'owe' => $myUser->id,
            'creditor' => $myFriend->id
        ]);
        $f3 = factory(Ledger::class)->create([
            'bill_no' => $bill2->id,
            'owe' => $myUser->id,
            'creditor' => $myFriend->id
        ]);
        factory(Ledger::class)->create([
            'bill_no' => $bill1->id,
            'creditor' => $myUser->id,
            'owe' => factory(User::class)->create()->id
        ]);
        $this->assertCount(4,LedgerBoundary::filterBy($myUser->id));
        $this->assertCount(3,LedgerBoundary::filterBy($myUser->id,$myGroup->id));
        $this->assertCount(2,LedgerBoundary::filterBy($myUser->id,$myGroup->id,$myFriend->id));
    }
}
