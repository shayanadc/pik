<?php

namespace Tests\Feature;

use App\Bill;
use App\Group;
use App\Ledger;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BillControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_creates_bill()
    {
        $response = $this->json('POST', 'api/bills', ['description' => 'for dinner', 'cost' => 183]);
        $bill = Bill::first();
        $this->assertEquals($bill->cost,183);
        $response
            ->assertStatus(200)
            ->assertJson([
                'description' => 'for dinner'
            ]);
    }
    /**
     * @test
     */
    public function it_get_bill_and_divide_between_members_and_create_ledger(){
        $owner = factory(User::class)->create();
        $bill = factory(Bill::class)->create(['cost' => 900,'description' => 'for dinner' , 'owner' => $owner->id]);
        $members = [0 => 1135,1 => 85,3 => $bill->owner];
        $response = $this->json('POST', 'api/ledgers', ['bill_id' => $bill->id, 'members' => $members]);
        $this->assertCount(2,Ledger::where('bill_no', $bill->id)->get());
        $this->assertCount(0,Ledger::where('owe', $bill->owner)->get());
        $response
            ->assertStatus(200)
            ->assertJson([
                'rows' => [['amount' => 300],['amount' => 300]]
            ]);
    }
    /**
     * @test
     */
    public function it_calc_owe_in_ledger_for_user_by_group(){
        $member1 = factory(User::class)->create();
        $member2 = factory(User::class)->create();
        $owner = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $bill1 = factory(Bill::class)->create(['owner' => $owner->id, 'cost' => 3000, 'description' => 'friday dinner', 'group_id' => $group->id]);
        $bill2 = factory(Bill::class)->create(['owner' => $owner->id, 'cost' => 9000, 'description' => 'friday breakfast', 'group_id' => $group->id]);
        factory(Ledger::class)->create(['bill_no' => $bill1->id, 'owe' => $owner->id, 'creditor' => $member1, 'amount' => 1000]);
        factory(Ledger::class)->create(['bill_no' => $bill1->id, 'owe' => $owner->id, 'creditor' => $member2, 'amount' => 1000]);
        factory(Ledger::class)->create(['bill_no' => $bill2->id, 'owe' => $owner->id, 'creditor' => $member1, 'amount' => 3000]);
        factory(Ledger::class)->create(['bill_no' => $bill2->id, 'owe' => $owner->id, 'creditor' => $member2, 'amount' => 3000]);
        $response = $this->json('GET', 'api/ledgers?user=' . $member1->id .'&group=' . $group->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                ['amount' => 1000],['amount' => 3000]
            ]);
    }
}
