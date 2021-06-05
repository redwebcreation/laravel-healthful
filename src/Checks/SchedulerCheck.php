<?php

namespace RWC\Healthful\Checks;

use RWC\Healthful\Models\Heartbeat;

class SchedulerCheck implements Check
{
    public function passes(): bool
    {
        $heartbeat = Heartbeat::query()
            ->where('type', Heartbeat::SCHEDULE)
            ->where('updated_at', '>=', now()->subMinutes(5))
            ->first();

        return $heartbeat !== null;
    }
}
