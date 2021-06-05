<?php

use RWC\Healthful\Checks\DatabaseCheck;
use RWC\Healthful\Tests\TestCase;

uses(TestCase::class);

it('passes', function () {
    usesDatabase();

    $check = new DatabaseCheck();

    expect($check->passes())->toBeTrue();
});

it('fails', function () {
    $check = new DatabaseCheck();

    expect($check->passes())->toBeFalse();
});
