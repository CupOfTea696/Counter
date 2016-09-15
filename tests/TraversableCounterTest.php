<?php

use CupOfTea\Counter\Counter;

class TraversableCounterTest extends PHPUnit_Framework_TestCase
{
    public function test_it_can_detect_traversable_length()
    {
        $traversable = [1, 2, 3];
        $counter = (new Counter())->loop($traversable);
        
        $this->assertEquals(count($traversable), $counter->length());
    }
    
    public function test_it_can_loop_over_travsersable()
    {
        $traversable = [1, 2, 3];
        $counter = (new Counter())->loop($traversable);
        
        $check = [];
        foreach ($counter as $item) {
            array_push($check, $item);
        }
        
        $this->assertEquals($check, $traversable);
    }
    
    public function test_it_can_loop_over_traversable_keys()
    {
        $traversable = ['one' => 1, 'two' => 2, 'three' => 3];
        $counter = (new Counter())->loop($traversable);
        
        $keys = [];
        foreach ($counter as $key => $item) {
            array_push($keys, $key);
        }
        
        $this->assertEquals($keys, array_keys($traversable));
    }
    
    public function test_it_can_update_the_traversable_position()
    {
        $traversable = [1, 2, 3];
        $counter = (new Counter())->loop($traversable);
        
        foreach ($counter as $item) {
            if ($item == 2) {
                break;
            }
        }
        
        $this->assertEquals(2, current($counter->getTraversable()));
    }
    
    public function test_it_is_seekable()
    {
        $traversable = ['one' => 1, 'two' => 2, 'three' => 3];
        $counter = (new Counter())->loop($traversable);
        
        $counter->seek(2);
        
        $this->assertEquals(3, current($counter->getTraversable()));
    }
}