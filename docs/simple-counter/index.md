---
layout: default
---

# Simple Counter
<!-- [[TOC]] -->

## Using a Simple Counter

If you just want to keep track of your iterations within a loop, you can use a Simple Counter instead. You can initialise a simple counter with the `start` method. Optionally, you can pass an Array, Countable or Integer to set the Counter's length.

```php
$counter = new Counter;
$counter->start();

while($condition === true) {
    ...
    
    $counter->tick(); // Always increment your counter right before closing the loop!
}
```

## Available methods

The simple counter has all methods of the normal (traversing) counter, although some of the implementations are slightly different. Only the methods with different implementations are listed below.

<!-- [[STOC]] -->

#### `last()`

Will always return false if no Counter length was specified using the `start` method. Otherwise behaves normally.

#### `item()`

This method will return `null`, since a Simple Counter does not keep track of any variable that may be looped. We recommend not using this method for Simple Counters to avoid confusion.

#### `length()`

If no length was specified using the `start` method, the PHP Constant `INF` will be returned.
