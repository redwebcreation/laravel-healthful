<?php

use RWC\Healthful\Checks\DatabaseCheck;
use RWC\Healthful\Checks\QueueCheck;
use RWC\Healthful\Checks\SchedulerCheck;

return [
    /* The route that should return the health status */
    'route' => '/_/health',

    /* A list of checks to be performed. */
    'checks' => [
        DatabaseCheck::class,
        SchedulerCheck::class,
        QueueCheck::class,
    ]
];
