<?php

namespace Tests\Feature;

use App\Bill;
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
}
