<?php

namespace Tests\Feature;

use App\Bill;
use App\BillLedgerInterActor;
use App\Group;
use App\Ledger;
use App\LedgerFactory;
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
    public function it_returns_user_in_ledger_for_user_by_group(){
        $member1 = factory(User::class)->create();
        $member2 = factory(User::class)->create();
        $owner = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $bill1 = factory(Bill::class)->create(['owner' => $member1->id, 'cost' => 3000, 'description' => 'friday dinner', 'group_id' => $group->id]);
        $bill2 = factory(Bill::class)->create(['owner' => $member2->id, 'cost' => 9000, 'description' => 'friday breakfast', 'group_id' => $group->id]);
        $bill3 = factory(Bill::class)->create(['owner' => $owner->id, 'cost' => 3000, 'description' => 'friday dinner', 'group_id' => $group->id]);
        $params1 = ['bill_owner' =>$bill1->owner ,'bill_no' => $bill1->id];
        $params2 = ['bill_owner' =>$bill2->owner ,'bill_no' => $bill2->id];
        $params3 = ['bill_owner' =>$bill3->owner ,'bill_no' => $bill3->id];
        $billLedger =  new BillLedgerInterActor();
        $billLedger->divideAndStoreBillInLedger(3000,[$member1->id,$member2->id],$params1);
        $billLedger->divideAndStoreBillInLedger(9000,[$member1->id,$member2->id],$params2);
        $billLedger->divideAndStoreBillInLedger(9000,[$owner->id,$member2->id],$params3);
        $response = $this->json('GET', 'api/ledgers?user=' . $member2->id .'&group=' . $group->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                ['amount' => 1500],['amount' => 4500],['amount' => 4500]
            ]);
    }
    /**
     * @test
     */
    public function it_returns_owe_and_creditor_of_specific_user(){
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $bill1 = factory(Bill::class)->create(
            ['owner' => $user1->id, 'cost' => 3000, 'description' => 'friday dinner', 'group_id' => $group->id]
        );
        $bill2 = factory(Bill::class)->create(
            ['owner' => $user2->id, 'cost' => 3000, 'description' => 'friday morning', 'group_id' => $group->id]
        );
        $params1 = ['bill_owner' =>$bill1->owner ,'bill_no' => $bill1->id];
        $params2 = ['bill_owner' =>$bill2->owner ,'bill_no' => $bill2->id];
        $billLedger =  new BillLedgerInterActor();
        $billLedger->divideAndStoreBillInLedger(1000,[$user1->id,$user2->id],$params1);
        $billLedger->divideAndStoreBillInLedger(3000,[$user1->id,$user2->id],$params2);
//        $ledger = Ledger::all();
//        $ldgf = new LedgerFactory();
//        $ldgf->getLedgerStatus($ledger->toArray());
//        $response = $this->json('GET', 'api/ledgers?user=' . $user1->id .'&ledger');
        $response = $this->json('GET', 'api/ledgers?user=' . $user1->id .'&friend' . $user2->id . '&ledger');
        $response
            ->assertStatus(200)
            ->assertJson([
                'creditor' => [User::find($user2->id)->toArray()],
                ]);

    }
    /**
     * @test
     */
    public function it_settle_ledger(){
        $ledger = factory(Ledger::class)->create();
        $ledger = Ledger::find($ledger->id);
        $this->assertFalse($ledger->settle);

        $response = $this->json('PUT', 'api/ledgers/'. $ledger->id, ['settle' => True]);
        $ledger = Ledger::find($ledger->id);
        $this->assertTrue($ledger->settle);
    }
}
