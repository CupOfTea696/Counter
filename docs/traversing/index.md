---
layout: default
---

# Traversing
<!-- [[TOC]] -->

## Traversing using loops

Counter's main usage is to loop over variables, keeping track of the current index. The `loop` method allows you to loop over any variable. If the variable isn't Traversable or an array, it will be cast to an array in order to loop over it. If the variable is an instance of `Illuminate\Contracts\Support\Arrayable`, it will use the `toArray` method to do so.

Alternatively, you can use the alias `traverse` instead.

```php
$myArray = ['r' => 128, 'g' => 0, 'b' => 0];
$counter = new Counter;

foreach($counter->loop($myArray) as $key => $value) {
    ...
}
```

## Available methods
<!-- [[STOC]] -->

#### `getTraversable()`

Get the item that is being traversed. This method returns the Traversable object, or an array.

#### `increment()`

Increment the counter by a given amount. The amount defaults to 1.

```php
$counter->increment();
$counter->increment(4);
```

#### `decrement()`

Decrement the counter by a given amount. The amount defaults to 1.

```php
$counter->decrement();
$counter->decrement(4);
```

#### `tick()`

Increment the counter by 1.

#### `first()`

Check if the current position is the initial position.

```php
$myArray = ['foo', 'bar', 'baz'];
$counter = new Counter;
$counter->loop($myArray);

$counter->first(); // true
$counter->tick();
$counter->first(); // false
```

#### `last()`

Check if the current position is the last position.

#### `nth()`

Check if the current iteration is the nth iteration. This method is 1 based.

```php
$myArray = ['foo', 'bar', 'baz'];
$counter = new Counter;
$counter->loop($myArray);

$counter->nth(1); // true
```

#### `even()`

Check if the current iteration is an even iteration. This method is 1 based.

#### `odd()`

Check if the current iteration is an odd iteration. This method is 1 based.

#### `item()`

Return the current element from the variable being Traversed.

#### `index()`

Get the current index. This method has an alias `i()` and `position()`.

```php
$myArray = ['foo', 'bar', 'baz'];
$counter = new Counter;
$counter->loop($myArray);

$counter->index(); // 0
```

#### `iteration()`

Get the current iteration.

```php
$myArray = ['foo', 'bar', 'baz'];
$counter = new Counter;
$counter->loop($myArray);

$counter->iteration(); // 1
```

#### `length()`

Get the length of the traversable.

```php
$myArray = ['foo', 'bar', 'baz'];
$counter = new Counter;
$counter->loop($myArray);

$counter->length(); // 3
```
