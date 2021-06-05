<?php

namespace RWC\Healthful\Tests;

use Orchestra\Testbench\TestCase as Base;
use RWC\Healthful\HealthfulServiceProvider;

class TestCase extends Base
{
    protected function getPackageProviders($app): array
    {
        return [HealthfulServiceProvider::class];
    }
}
