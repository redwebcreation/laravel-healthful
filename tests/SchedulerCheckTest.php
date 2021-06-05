<?php

use RWC\Healthful\Checks\SchedulerCheck;
use RWC\Healthful\Models\Heartbeat;
use RWC\Healthful\Tests\TestCase;

uses(TestCase::class);

it('passes', function () {
    usesDatabase();
    Heartbeat::create([
        'type' => Heartbeat::SCHEDULE,
    ]);

    $check = new SchedulerCheck();

    expect($check->passes())->toBeTrue();
});

it('fails', function () {
    usesDatabase();
    $check = new SchedulerCheck();

    expect($check->passes())->toBeFalse();
});
