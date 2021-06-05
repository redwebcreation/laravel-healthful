<?php

namespace RWC\Healthful;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use RWC\Healthful\Jobs\HeartbeatJob;
use RWC\Healthful\Models\Heartbeat;
use Throwable;

class HealthfulServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/healthful.php', 'healthful');

        if (!$this->app->runningInConsole()) {
            return;
        }

        if (!class_exists('CreateHeartbeatsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_heartbeats_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_heartbeats_table.php'),
            ], ['healthful-migrations', 'healthful']);
        }

        $this->publishes([
            __DIR__ . '/../config/healthful.php' => config_path('healthful.php'),
        ], ['healthful-config', 'healthful']);
    }

    public function register(): void
    {
        $this->app->bind('health', fn () => new Health([
            ...config('healthful.checks'),
        ]));

        $this->app->booted(function () {
            $scheduler = $this->app->make(Schedule::class);

            $scheduler->job(HeartbeatJob::class)->everyMinute();
            $scheduler->command('heartbeat')->everyMinute();

            // When running unit tests for this package
            // We do not create a database right away this is the simplest solution
            // To fix it.
            try {
                Heartbeat::query()
                    ->where('type', Heartbeat::INITIALIZATION)
                    ->firstOrCreate(['type' => Heartbeat::INITIALIZATION]);
            } catch (Throwable $e) {
            }
        });
    }
}
