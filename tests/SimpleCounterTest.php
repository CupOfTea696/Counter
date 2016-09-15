<?php

use CupOfTea\Counter\Counter;

class SimpleCounterTest extends PHPUnit_Framework_TestCase
{
    public function test_it_can_increment()
    {
        // Arrange
        $counter = (new Counter())->start();
        
        $counter->increment();
        
        $this->assertEquals(1, $counter->i());
        
        $counter->increment(0);
        
        $this->assertEquals(1, $counter->i());
        
        $counter->increment(1);
        
        $this->assertEquals(2, $counter->i());
        
        $counter->increment(4);
        
        $this->assertEquals(6, $counter->i());
    }
    
    /**
     * @depends test_it_can_increment
     */
    public function test_it_can_decrement()
    {
        // Arrange
        $counter = (new Counter())->start();
        $counter->increment(10);
        
        $counter->decrement();
        
        $this->assertEquals(9, $counter->i());
        
        $counter->decrement(0);
        
        $this->assertEquals(9, $counter->i());
        
        $counter->decrement(1);
        
        $this->assertEquals(8, $counter->i());
        
        $counter->decrement(4);
        
        $this->assertEquals(4, $counter->i());
    }
    
    /**
     * @depends test_it_can_increment
     */
    public function test_it_can_tick()
    {
        $counter = (new Counter())->start();
        
        $counter->tick();
        
        $this->assertEquals(1, $counter->i());
    }
    
    public function test_it_can_have_a_length()
    {
        $counter = (new Counter())->start(1);
        
        $this->assertEquals(1, $counter->length());
    }
    
    /**
     * @depends test_it_can_tick
     */
    public function test_it_can_detect_first_iteration()
    {
        $counter = (new Counter())->start();
        
        $this->assertTrue($counter->first());
        
        $counter->tick();
        
        $this->assertFalse($counter->first());
    }
    
    /**
     * @depends test_it_can_tick
     */
    public function test_it_can_detect_last_iteration()
    {
        $counter = (new Counter())->start(2);
        
        $this->assertFalse($counter->last());
        
        $counter->tick();
        
        $this->assertTrue($counter->last());
    }
    
    /**
     * @depends test_it_can_tick
     */
    public function test_it_can_detect_even_iteration()
    {
        $counter = (new Counter())->start();
        
        $this->assertFalse($counter->even());
        
        $counter->tick();
        
        $this->assertTrue($counter->even());
    }
    
    /**
     * @depends test_it_can_tick
     */
    public function test_it_can_detect_odd_iteration()
    {
        $counter = (new Counter())->start();
        
        $this->assertTrue($counter->odd());
        
        $counter->tick();
        
        $this->assertFalse($counter->odd());
    }
    
    /**
     * @depends test_it_can_increment
     */
    public function test_it_can_detect_nth_iteration()
    {
        $counter = (new Counter())->start();
        
        $this->assertFalse($counter->nth(3));
        
        $counter->increment(2);
        
        $this->assertTrue($counter->nth(3));
    }
    
    /**
     * @depends test_it_can_increment
     */
    public function test_it_can_detect_nth_expressions()
    {
        $counter = (new Counter())->start();
        
        $this->assertFalse($counter->nth('3n'));
        $this->assertTrue($counter->nth('3n + 1'));
        $this->assertFalse($counter->nth('3n-1'));
        
        $counter->increment(1);
        
        $this->assertFalse($counter->nth('3n'));
        $this->assertFalse($counter->nth('3n + 1'));
        $this->assertTrue($counter->nth('3n-1'));
        
        $counter->increment(1);
        
        $this->assertTrue($counter->nth('3n'));
        $this->assertFalse($counter->nth('3n + 1'));
        $this->assertFalse($counter->nth('3n-1'));
    }
}
