# Event dispatcher for PHP
[![Tests](https://github.com/mrjeanjean/psr-14-implementation/actions/workflows/ci.yml/badge.svg)](https://github.com/mrjeanjean/psr-14-implementation/actions?query=workflow%3ACI)

Simple psr-14 (event dispatcher) implementation. Unit tests and CI through Github Actions.


## How to use?
```php

use Moveo\EventDispatcher\EventDispatcher;
use Moveo\EventDispatcher\ListenerProvider;

// Load sources using composer
require __DIR__ . '/../vendor/autoload.php';

// New instance of the listener provider
$listenerProvider = new ListenerProvider();

// New instance of the event dispatcher
$eventDispatcher = new EventDispatcher($listenerProvider);

// Add two listeners into the listener provider
$listenerProvider->addListener(\stdClass::class, function(){
    echo "1";
});

$listenerProvider->addListener(\stdClass::class, function(){
    echo "2";
});

// Create and dispatch event
// Display "12"
$event = new \stdClass();
$eventDispatcher->dispatch($event);
```
