<?php

namespace Tests\Feature;

use App\LedgerFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LedgerFactoryTest extends TestCase
{
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
                ['creditor' => 'shayan', 'owee' => 'nietzsche', 'amount' => 20000],
                ['creditor' => 'shayan', 'owee' => 'fruid', 'amount' => 20000]
                ]
        ],
            $outputArray);

    }
    /**
     * @test
     */
    public function it_calculates_members_status_in_ledger(){
        $input = [
            ['creditor' => 'A' , 'owee' => 'B', 'amount' => 10000],
            ['creditor' => 'A' , 'owee' => 'B', 'amount' => 40000],
            ['creditor' => 'A' , 'owee' => 'C', 'amount' => 20000],
        ];
        $ledgerFactory = new LedgerFactory();
        $output = $ledgerFactory->calcStatus($input);
        $this->assertEquals([
            ['creditor' => 'A' , 'owee' => 'B', 'amount' => 50000],
            ['creditor' => 'A' , 'owee' => 'C', 'amount' => 20000],
        ],$output);
    }
}
