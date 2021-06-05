<?php

namespace RWC\Healthful;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use RWC\Healthful\Jobs\Heartbeat;
use RWC\Healthful\Models\Heartbeat as HeartbeatModel;
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
            __DIR__ . '/../config/healthful.php' => config_path('healthful.hp'),
        ], ['healthful-config', 'healthful']);
    }

    public function register(): void
    {
        $this->app->bind('health', fn () => new Health([
            ...config('healthful.checks'),
        ]));

        $this->app->booted(function () {
            $scheduler = $this->app->make(Schedule::class);

            $scheduler->job(Heartbeat::class)->everyMinute();
            $scheduler->command('heartbeat')->everyMinute();

            // When running unit tests for this package
            // We do not create a database right away this is the simplest solution
            // To fix it.
            try {
                HeartbeatModel::query()
                    ->where('type', HeartbeatModel::INITIALIZATION)
                    ->firstOrNew(['type' => HeartbeatModel::INITIALIZATION]);
            } catch (Throwable $e) {
            }
        });
    }
}
