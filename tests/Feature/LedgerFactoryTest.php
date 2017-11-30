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
}
