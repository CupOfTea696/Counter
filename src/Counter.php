<?php namespace CupOfTea\Counter;

use Iterator;
use Countable;
use Traversable;
use ArrayIterator;
use SeekableIterator;
use IteratorAggregate;
use OutOfBoundsException;
use InvalidArgumentException;
use CupOfTea\Package\Package;

class Counter implements SeekableIterator
{
    use Package;
    
    /**
     * Package Name.
     *
     * @const string
     */
    const PACKAGE = 'CupOfTea/Counter';
    
    /**
     * Package Version.
     *
     * @const string
     */
    const VERSION = '1.1.0';
    
    /**
     * The current position.
     *
     * @var int
     */
    private $i = 0;
    
    /**
     * The length of the traversable or counter.
     *
     * @var int
     */
    private $length;
    
    /**
     * The Traversable.
     *
     * @var \Iterator
     */
    private $traversable;
    
    //
    // Traversing counter
    //
    
    /**
     * Loop over a variable.
     *
     * @param  mixed  $traversable
     * @return \CupOfTea\Support\Counter
     */
    public function loop($traversable)
    {
        $this->clear();
        $this->setTraversable($traversable);
        $this->setLength($this->traversable);
        
        return $this;
    }
    
    /**
     * Resolve the variable we are looping over to something traversable.
     *
     * @param  mixed  $traversable
     * @return void
     */
    private function setTraversable($traversable)
    {
        $traversable = $this->value($traversable);
        
        if ($traversable instanceof Iterator) {
            $this->traversable = $traversable;
        } elseif ($traversable instanceof IteratorAggregate) {
            $this->traversable = $traversable->getIterator();
        } elseif (class_exists('Illuminate\Contracts\Support\Arrayable') && $traversable instanceof \Illuminate\Contracts\Support\Arrayable) {
            $this->traversable = new ArrayIterator($traversable->toArray());
        } else {
            $this->traversable = new ArrayIterator((array) $traversable);
        }
    }
    
    /**
     * Get the item that's being traversed.
     *
     * @return \Traversable|array
     */
    public function getTraversable()
    {
        if ($this->traversable instanceof ArrayIterator) {
            $array = $this->traversable->getArrayCopy();
            
            for ($i = 0; $i < $this->i; $i++) {
                next($array);
            }
            
            return $array;
        }
        
        return $this->traversable;
    }
    
    /**
     * Determine if a traversable is set.
     *
     * @return bool
     */
    private function traversable()
    {
        return isset($this->traversable);
    }
    
    /**
     * Determine the length of a countable.
     *
     * @param  mixed  $countable
     * @return void
     */
    private function setLength($countable)
    {
        $countable = $this->value($countable);
        
        if ($this->isInt($countable)) {
            $this->length = (int) $countable;
        } elseif (is_array($countable) || $countable instanceof Countable) {
            $this->length = count($countable);
        } elseif (class_exists('Illuminate\Contracts\Support\Arrayable') && $countable instanceof \Illuminate\Contracts\Support\Arrayable) {
            $this->length = count($countable->toArray());
        } elseif ($countable instanceof Traversable) {
            $this->length = 0;
            
            foreach ($countable as $v) {
                $this->length++;
            }
        } else {
            $this->length = INF;
        }
    }
    
    //
    // SeekableIterator implementation
    //
    
    /**
     * Seeks to a position.
     *
     * @param  int  $position
     * @return void
     * @throws \InvalidArgumentException when $position is not an integer.
     * @throws \OutOfBoundsException when the seek $position exeeds the traversable's length.
     */
    public function seek($position)
    {
        if (! $this->isInt($position)) {
            throw new InvalidArgumentException('Seek position must be an integer.');
        }
        
        $position = max(0, (int) $position);
        
        if ($this->length !== null && $this->length < $position) {
            throw new OutOfBoundsException('Invalid seek position (' . $position . ').');
        }
        
        if ($this->traversable()) {
            if ($this->traversable instanceof SeekableIterator) {
                $this->traversable->seek($position);
            } else {
                $this->traversable->rewind();
                
                for ($i = 0; $i < $position; $i++) {
                    $this->traversable->next();
                }
            }
        }
        
        $this->i = $position;
    }
    
    /**
     * Set the internal pointer of the traversable to its first element.
     *
     * @return mixed
     */
    public function rewind()
    {
        $this->i = 0;
        
        if ($this->traversable()) {
            $this->traversable->rewind();
            
            return $this->length !== 0 ? $this->traversable->current() : false;
        }
        
        return $this->i;
    }
    
    /**
     * Return the current element in the traversable.
     *
     * @return mixed
     */
    public function current()
    {
        if ($this->traversable()) {
            return $this->traversable->current();
        }
        
        return $this->i;
    }
    
    /**
     * Return the index element of the current traversable position.
     *
     * @return mixed
     */
    public function key()
    {
        if ($this->traversable()) {
            return $this->traversable->key();
        }
        
        return $this->i;
    }
    
    /**
     * Advance the internal array pointer of the traversable.
     *
     * @return mixed
     */
    public function next()
    {
        $this->i++;
        
        if ($this->traversable()) {
            $this->traversable->next();
            
            return $this->traversable->current();
        }
        
        return $this->i;
    }
    
    /**
     * Rewind the internal array pointer of the traversable.
     *
     * @return mixed
     */
    public function prev()
    {
        $this->i = max(0, $this->i - 1);
        
        if ($this->traversable()) {
            $this->seek($this->i);
            
            return $this->traversable->current();
        }
        
        return $this->i;
    }
    
    /**
     * Checks if current position of the traversable is valid.
     *
     * @return bool
     */
    public function valid()
    {
        if ($this->traversable()) {
            $key = $this->traversable->key();
            
            // The is_null check is a safetyguard to make sure we don't end up
            // in an infinite loop if some idiot decided to use null as a key.
            return ! is_null($key) && $this->traversable->valid();
        }
        
        return $this->i < $this->length;
    }
    
    /**
     * Set the internal pointer of the traversable to its last element.
     *
     * @return mixed
     */
    public function end()
    {
        if ($this->traversable()) {
            if ($this->length !== 0) {
                $this->seek($this->length);
                
                return $this->traversable->current();
            }
            
            return false;
        }
        
        return ! is_null($this->length) ? $this->length : false;
    }
    
    //
    // Simple counter
    //
    
    /**
     * Start a simple counter.
     *
     * @param  bool|int  $length
     * @return void
     */
    public function start($length = false)
    {
        $this->clear();
        $this->setLength($length);
        
        return $this;
    }
    
    //
    // Counter methods
    //
    
    /**
     * Increment the counter by a specified amount.
     *
     * @param  int  $by
     * @return void
     */
    public function increment($by = 1)
    {
        switch ($by) {
            case 0:
                break;
            case 1:
                $this->next();
                break;
            default:
                $seek = $this->traversable() ? min($this->length - 1, $this->i + $by) : $this->i + $by;
                
                $this->seek($seek);
                break;
        }
    }
    
    /**
     * Decrement the counter by a specified amount.
     *
     * @param  int  $by
     * @return void
     */
    public function decrement($by = 1)
    {
        switch ($by) {
            case 0:
                break;
            case 1:
                $this->prev();
                break;
            default:
                $this->seek(max(0, $this->i - $by));
                break;
        }
    }
    
    /**
     * Increment the counter by 1.
     *
     * @return void
     */
    public function tick()
    {
        $this->increment();
    }
    
    /**
     * Check if the current position is the initial position.
     *
     * @return bool
     */
    public function first()
    {
        return $this->i == 0;
    }
    
    /**
     * Check if the current position is the last position.
     * Will always return false if no length was
     * specified for a simple counter.
     *
     * @return bool
     */
    public function last()
    {
        return $this->length !== null && $this->i + 1 >= $this->length;
    }
    
    /**
     * Check if the current iteration is the nth iteration (1 based).
     *
     * @return bool
     */
    public function nth($n)
    {
        if (is_string($n) && preg_match('/^(\d+)n(?:\s*([+-])\s*(\d+))?$/', $n, $matches)) {
            $x = (int) $matches[1];
            $add = (int) ((! empty($matches[2]) ? $matches[2] : '') . (! empty($matches[3]) ? $matches[3] : 0));
            
            return ($this->iteration() - $add) % $x == 0;
        }
        
        if (! $this->isInt($n)) {
            throw new InvalidArgumentException('$n must be an integer or a valid n-th expression.');
        }
        
        return $this->iteration() % $n == 0;
    }
    
    /**
     * Check if the current iteration is an even iteration (1 based).
     *
     * @return bool
     */
    public function even()
    {
        return $this->nth(2);
    }
    
    /**
     * Check if the current iteration is an odd iteration (1 based).
     *
     * @return bool
     */
    public function odd()
    {
        return ! $this->even();
    }
    
    /**
     * Return the current element.
     *
     * @return mixed
     */
    public function item()
    {
        if ($this->traversable()) {
            return $this->current();
        }
    }
    
    /**
     * Get the current position.
     *
     * @return int
     */
    public function index()
    {
        return $this->i;
    }
    
    /**
     * Get the current iteration.
     *
     * @return int
     */
    public function iteration()
    {
        return $this->i + 1;
    }
    
    /**
     * Get the length of the traversable or the counter.
     *
     * @return float
     */
    public function length()
    {
        return $this->length;
    }
    
    /**
     * Reset the counter to its default state.
     *
     * @return void
     */
    private function clear()
    {
        $this->i = 0;
        $this->length = $this->traversable = null;
    }
    
    //
    // helper methods
    //
    
    /**
     * Check if a variable is castable to an integer.
     *
     * @param  mixed  $int
     * @return bool
     */
    private function isInt($int)
    {
        return (is_numeric($int) && (int) $int == (float) $int) || is_null($int);
    }
    
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
    
    //
    // method aliases
    //
    
    /**
     * @see \CupOfTea\Support\Counter::loop
     */
    public function traverse($traversable)
    {
        return $this->loop($traversable);
    }
    
    /**
     * @see \CupOfTea\Support\Counter::index
     */
    public function i()
    {
        return $this->index();
    }
    
    /**
     * @see \CupOfTea\Support\Counter::index
     */
    public function position()
    {
        return $this->index();
    }
}
