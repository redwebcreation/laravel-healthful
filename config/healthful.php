<?php

use RWC\Healthful\Checks\DatabaseCheck;
use RWC\Healthful\Checks\QueueCheck;
use RWC\Healthful\Checks\SchedulerCheck;

return [
    /**
     * A list of checks to be performed.
     */
    'checks' => [
        DatabaseCheck::class,
        SchedulerCheck::class,
        QueueCheck::class,
    ]
];
