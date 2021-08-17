<?php

namespace RWC\Healthful;

use Illuminate\Support\Facades\Route;
use RWC\Healthful\Checks\Check;
use RWC\Healthful\Controllers\HealthcheckController;

class Health
{
    /** @var Check[]|class-string[] */
    protected array $checks;

    public function __construct(array $checks = [])
    {
        $this->checks = $checks;
    }

    public static function route(): \Illuminate\Routing\Route
    {
        return Route::get(config('healthful.route'), HealthcheckController::class)->name('healthcheck');
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
