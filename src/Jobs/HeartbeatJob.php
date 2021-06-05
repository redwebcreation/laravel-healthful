<?php

namespace RWC\Healthful\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RWC\Healthful\Models\Heartbeat;

class HeartbeatJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public function handle(): void
    {
        $heartbeat = Heartbeat::firstOrNew([
            'type' => Heartbeat::JOB,
        ]);

        $heartbeat->updateTimestamps();
        $heartbeat->save();
    }
}
