<?php

use RWC\Healthful\Facades\Health;
use RWC\Healthful\Models\Heartbeat;
use RWC\Healthful\Tests\TestCase;

uses(TestCase::class);

it('returns true when application is healthy', function () {
    usesDatabase();

    Heartbeat::create(['type' => Heartbeat::SCHEDULE]);
    Heartbeat::create(['type' => Heartbeat::JOB]);

    $health = Health::check();

    expect($health)->toBeTrue();
});

it('returns false when application is not healthy', function () {
    $health = Health::check();

    expect($health)->toBeFalse();
});
