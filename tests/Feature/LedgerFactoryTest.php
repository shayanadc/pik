<?php

namespace Tests\Feature;

use App\Ledger;
use App\LedgerFactory;
use App\BillLedgerInterActor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LedgerFactoryTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_divides_specific_amount_between_members()
    {
        $ledgerFactory = new LedgerFactory();
        $params = ['bill_no' => 2, 'bill_owner' => 'shayan'];
        $outputArray = $ledgerFactory->divide(60000, ['nietzsche','fruid','shayan'], $params);
        $this->assertEquals([ 'bill_no' => 2,
            'rows' => [
                ['creditor' => 'shayan', 'owe' => 'nietzsche', 'amount' => 20000],
                ['creditor' => 'shayan', 'owe' => 'fruid', 'amount' => 20000]
                ]
        ],
            $outputArray);
    }

    /**
     * @test
     */
    public function it_divides_and_store_specific_amount_between_members()
    {
        $ledgerFactory = new BillLedgerInterActor();
        $params = ['bill_no' => 2, 'bill_owner' => 2];
        $outputArray = $ledgerFactory->divideAndStoreBillInLedger(60000, [4,1,2], $params);
        $this->assertCount(2,Ledger::all());
        $this->assertEquals([ 'bill_no' => 2,
            'rows' => [
                ['creditor' => 2, 'owe' => 4, 'amount' => 20000],
                ['creditor' => 2, 'owe' => 1, 'amount' => 20000]
            ]
        ],
            $outputArray);

    }
    /**
     *
     */
//    public function it_calculates_members_status_in_ledger(){
//        $input = [
//            ['creditor' => 'A' , 'owee' => 'B', 'amount' => 10000],
//            ['creditor' => 'A' , 'owee' => 'B', 'amount' => 40000],
//            ['creditor' => 'A' , 'owee' => 'C', 'amount' => 20000],
//        ];
//        $ledgerFactory = new LedgerFactory();
//        $output = $ledgerFactory->calcStatus($input);
//        $this->assertEquals([
//            ['creditor' => 'A' , 'owee' => 'B', 'amount' => 50000],
//            ['creditor' => 'A' , 'owee' => 'C', 'amount' => 20000],
//        ],$output);
//    }
    /**
     * @test
     * @dataProvider calcProvider
     */
    public function it_calculates_members_status_in_ledger_book($arrays,$expected){
        $ledgerFactory = new LedgerFactory();
        $calcArray = $ledgerFactory->calcStatus($arrays);
        $this->assertEquals($expected, $calcArray);
    }
    public function calcProvider(){
        $case1 = [
            ['creditor' => 'A' , 'owe' => 'B', 'amount' => 10000],
            ['creditor' => 'A' , 'owe' => 'B', 'amount' => 40000],

            ['creditor' => 'F' , 'owe' => 'E', 'amount' => 20000],
            
            ['creditor' => 'D' , 'owe' => 'C', 'amount' => 20000],
            ['creditor' => 'C' , 'owe' => 'D', 'amount' => 10000]
        ];
        $result1 = [
            ['creditor' => 'A' , 'owe' => 'B', 'amount' => 50000],

            ['creditor' => 'F' , 'owe' => 'E', 'amount' => 20000],

            ['creditor' => 'D' , 'owe' => 'C', 'amount' => 10000]
        ];
        return [
      [$case1, $result1]
        ];

    }
}
