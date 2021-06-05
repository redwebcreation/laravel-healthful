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

it('skips if initialization is less than 5 minutes ago', function () {
    $check = new QueueCheck();
    expect($check->passes())->toBeFalse();

    Heartbeat::create([
        'type'       => Heartbeat::INITIALIZATION,
        'created_at' => now()->subMinute(),
    ]);

    expect($check->passes())->toBeTrue();
});

it('fails even with an initialization beat', function () {
    $check = new QueueCheck();

    expect($check->passes())->toBeFalse();

    Heartbeat::create([
        'type'       => Heartbeat::INITIALIZATION,
        'created_at' => now()->subMinutes(5)->subSecond(),
    ]);

    expect($check->passes())->toBeTrue();
});
