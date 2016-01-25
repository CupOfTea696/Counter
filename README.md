<!-- header start -->
[![Latest Stable Version](https://poser.pugx.org/cupoftea/counter/version.svg)](https://packagist.org/packages/cupoftea/counter) [![Total Downloads](https://poser.pugx.org/cupoftea/counter/d/total.svg)](https://packagist.org/packages/cupoftea/counter) [![Latest Unstable Version](https://poser.pugx.org/cupoftea/counter/v/unstable.svg)](https://packagist.org/packages/cupoftea/counter)
[![StyleCI](https://styleci.io/repos/36997384/shield?style=flat)](https://styleci.io/repos/36997384)
[![License](https://poser.pugx.org/cupoftea/counter/license.svg)](https://packagist.org/packages/cupoftea/counter)

# Counter
### Simple indexed looping.
<!-- header end -->

Easily loop over any Traversable or array while keeping track of the index. It will also accept any other variable types, and cast those to an array.

With Counter you can both keep track of the current index and iteration, regardless of which keys are being used. In addition to that, Counter also provides a stack of useful methods to check if the current iteration matches and requirements, for example `Counter::first()` and `Counter::even()`.

 - [Documentation](http://counter.cupoftea.io/docs/)
 - [API Reference](http://counter.cupoftea.io/docs/api/)

## Quickstart

```bash
$ composer require cupoftea/counter ^1.0
```

### Laravel integration

Add the Counter ServiceProvider to you `config/app.php`.

```php
	'providers' => [
        
		/*
		 * Laravel Framework Service Providers...
		 */
        
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Bus\BusServiceProvider',
        
        ...
        
        'CupOfTea\Counter\CounterServiceProvider',
        
	],
```

Optionally you can also add the Counter Facade if you wish to use it.

```php
    'aliases' => [
        
		'App'       => 'Illuminate\Support\Facades\App',
		'Artisan'   => 'Illuminate\Support\Facades\Artisan',
		'Auth'      => 'Illuminate\Support\Facades\Auth',
		
		...
		
        'Counter' => 'CupOfTea\Counter\Facades\Counter',
        
	],
```
