<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    /**
     * @test
     */
    public function it_sum_two_and_two(){
        $x = new User();
        $sum = $x->sum(2,4);
        $this->assertEquals($sum,6);
    }
}
