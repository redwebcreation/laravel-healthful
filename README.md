# Healthful for Laravel

This package is meant to be used with Docker's `HEALTHCHECK` directive and has been designed accordingly.

[![Tests](https://github.com/redwebcreation/laravel-healthful/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/redwebcreation/laravel-healthful/actions/workflows/tests.yml)
[![Formats](https://github.com/redwebcreation/laravel-healthful/actions/workflows/formats.yml/badge.svg?branch=master)](https://github.com/redwebcreation/laravel-healthful/actions/workflows/formats.yml)
[![Version](https://poser.pugx.org/redwebcreation/laravel-healthful/version)](//packagist.org/packages/redwebcreation/laravel-healthful)
[![Total Downloads](https://poser.pugx.org/redwebcreation/laravel-healthful/downloads)](//packagist.org/packages/redwebcreation/laravel-healthful)
[![License](https://poser.pugx.org/redwebcreation/laravel-healthful/license)](//packagist.org/packages/redwebcreation/laravel-healthful)

## Installation

> Requires [PHP 8.0+](https://php.net/releases)

You can install the package via composer:

```bash
composer require redwebcreation/laravel-healthful
```

The package will automatically register itself.

You'll need to publish the migrations :

```bash
php artisan vendor:publish --tag="healthful-migrations"
```

Optionally you can publish the config file:

```bash
php artisan vendor:publish --tag="healthful-config"
```

This is the contents of the published config file:

```php
<?php

use RWC\Healthful\Checks\DatabaseCheck;
use RWC\Healthful\Checks\QueueCheck;
use RWC\Healthful\Checks\SchedulerCheck;

return [
    /* The route that should return the health status */
    'route' => '/_/health',

    /* A list of checks to be performed. */
    'checks' => [
        DatabaseCheck::class,
    ]
];
```

## Usage

Check if your application is healthy :

```php
use RWC\Healthful\Facades\Health;

Health::check();
```

It returns true if all the checks were true or false if one failed.

You may want to expose your application's health publicly :

```php
use RWC\Healthful\Facades\Health;

Health::route()->name('healthcheck');
```

It registers a route at `/_/health` that returns a 200 if all the checks passed, or a 503 if one of them doesn't.

### Custom checks

```php
// app/HealthChecks/IsMondayCheck.php
use RWC\Healthful\Checks\Check;

class IsMondayCheck implements Check {
    public function passes() : bool{
        // Monday is never healthful.
        return !now()->isMonday();
    }
}
```

```php
// config/healthful.php
return [
    'checks' => [
        // ...
        IsMondayCheck::class
    ]
    
];
```

You can also use the `Heartbeat` model :

```php
use RWC\Healthful\Models\Heartbeat;

$heartbeat = Heartbeat::firstOrNew([
    'type' => 100 // any number above 100
]);

$heartbeat->updateTimestamps();
$heartbeat->save();
```

You need to specify a `type` above 100 so heartbeats of other kinds provided by this package won't ever collide with
yours.

Then, in your check :
<

```php
use RWC\Healthful\Checks\Check;
use RWC\Healthful\Models\Heartbeat;

class MyCheck implements Check {
    public function passes(): bool {
        $heartbeat = Heartbeat::query()
            ->where('type', 100)
            ->where('updated_at', '>=', now()->subMinutes(5))
            ->first();

        return $heartbeat !== null;
    }
}
```

### Integration with Docker

```dockerfile
# Dockerfile
HEALTHCHECK --interval=1m --timeout=30s --retries=3 CMD curl --fail http://localhost/_/health || exit 1
```

## Testing

```bash
composer test
```

**Healthful for Laravel** was created by **[F??lix Dorn](https://twitter.com/afelixdorn)** under
the **[MIT license](https://opensource.org/licenses/MIT)**.
