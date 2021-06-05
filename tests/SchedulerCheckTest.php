<?php

use RWC\Healthful\Checks\SchedulerCheck;
use RWC\Healthful\Models\Heartbeat;
use RWC\Healthful\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    useDatabase();
});

it('passes', function () {
    Heartbeat::create([
        'type' => Heartbeat::SCHEDULE,
    ]);

    $check = new SchedulerCheck();

    expect($check->passes())->toBeTrue();
});

it('fails', function () {
    $check = new SchedulerCheck();

    expect($check->passes())->toBeFalse();
});
