<?php

use RWC\Healthful\Checks\QueueCheck;
use RWC\Healthful\Models\Heartbeat;
use RWC\Healthful\Tests\TestCase;

uses(TestCase::class);

it('passes', function () {
    usesDatabase();
    Heartbeat::create([
        'type' => Heartbeat::JOB,
    ]);

    $check = new QueueCheck();

    expect($check->passes())->toBeTrue();
});

it('fails', function () {
    usesDatabase();
    $check = new QueueCheck();

    expect($check->passes())->toBeFalse();
});
