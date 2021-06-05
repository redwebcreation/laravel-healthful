<?php

namespace RWC\Healthful\Commands;

use Illuminate\Console\Command;
use RWC\Healthful\Models\Heartbeat as HeartbeatModel;

class Heartbeat extends Command
{
    protected $signature = 'heartbeat';

    protected $description = 'Registers a SCHEDULE heartbeat.';

    public function handle(): void
    {
        /** @var HeartbeatModel $heartbeat */
        $heartbeat = HeartbeatModel::firstOrNew([
            'type' => HeartbeatModel::SCHEDULE,
        ]);

        $heartbeat->updateTimestamps();
        $heartbeat->save();
    }
}
