<?php

namespace RWC\Healthful\Controllers;

use Illuminate\Http\Response;
use RWC\Healthful\Facades\Health;

class HealthcheckController
{
    public function __invoke(): Response
    {
        /* @phpstan-ignore-next-line */
        return response('', Health::check() ? 200 : 503);
    }
}
