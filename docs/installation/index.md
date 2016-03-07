---
layout: default
---

# Installation
<!-- [[TOC]] -->

## Install Composer

To install Counter, you will first need to install [Composer](https://getcomposer.org/doc/00-intro.md) if you haven't already.


## Install Counter

### Install via Composer

To install Counter, simply require it with Composer.

```bash
$ composer require cupoftea/counter ^1.0
````

Once composer is done downloading Counter, you're ready to use it!

### Laravel integration

Add the Counter ServiceProvider to your `config/app.php`.

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
