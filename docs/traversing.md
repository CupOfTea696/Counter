# Traversing
<!-- [[TOC]] -->

## Traversing using loops

Counter's main usage is to loop over variables, keeping track of the current index. The `loop` method allows you to loop over any variable. If the variable isn't Traversable or an array, it will be cast to an array in order to loop over it. If the variable is an instance of `Illuminate\Contracts\Support\Arrayable`, it will use the `toArray` method to do so.

```php
$myArray = ['foo', 'bar', 'baz'];
$counter = new Counter;

foreach($counter->loop($myArray) as $value) {
    ...
}
```

## Available methods

- Loop
- getTraversable

#### getTraversable
