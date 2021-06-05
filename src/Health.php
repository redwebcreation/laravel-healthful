<?php

namespace RWC\Healthful;

use Illuminate\Support\Facades\Route;
use RWC\Healthful\Checks\Check;
use RWC\Healthful\Controllers\HealthcheckController;

class Health
{
    public static string $route = '/_/health';

    /** @var Check[]|class-string[] */
    protected array $checks;

    public function __construct(array $checks = [])
    {
        $this->checks = $checks;
    }

    public static function route(): \Illuminate\Routing\Route
    {
        return Route::get(static::$route, HealthcheckController::class)->name('healthcheck');
    }

    public function check(): bool
    {
        foreach ($this->checks as $check) {
            if (is_string($check)) {
                $check = app($check);
            }

            if (!$check->passes()) {
                return false;
            }
        }

        return true;
    }
}
