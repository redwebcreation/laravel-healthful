<?php

namespace RWC\Healthful\Commands;

use Illuminate\Console\Command;
use RWC\Healthful\Models\Heartbeat;

class HeartbeatCommand extends Command
{
    protected $signature = 'schedule:heartbeat';

    protected $description = 'Registers a SCHEDULE heartbeat.';

    public function handle(): void
    {
        $heartbeat = Heartbeat::firstOrNew([
            'type' => Heartbeat::SCHEDULE,
        ]);

        $heartbeat->updateTimestamps();
        $heartbeat->save();
    }
}
