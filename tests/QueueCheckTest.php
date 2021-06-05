<?php

use RWC\Healthful\Checks\QueueCheck;
use RWC\Healthful\Models\Heartbeat;
use RWC\Healthful\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    useDatabase();
});

it('passes', function () {
    Heartbeat::create([
        'type' => Heartbeat::JOB,
    ]);

    $check = new QueueCheck();

    expect($check->passes())->toBeTrue();
});

it('fails', function () {
    $check = new QueueCheck();

    expect($check->passes())->toBeFalse();
});
