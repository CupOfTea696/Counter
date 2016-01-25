# Counter

## Simple counter

```php
$counter = new Counter();

$counter->start($my_array);

foreach($my_array as $key => $value) {
  if ($counter->first()) {
    echo "The first item in this array is " . $value;
  }
  
  echo "$key => $value";
  
  if ($counter->last()) {
    echo "The last item in this array has the key " . $key;
  }
}
```

## Traversable counter

```php
foreach($counter->loop($my_traversable_object) as $key => $value) {
  //
}
```
