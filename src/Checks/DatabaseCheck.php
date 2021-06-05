<?php

namespace RWC\Healthful\Checks;

use DB;
use Throwable;

class DatabaseCheck implements Check
{
    public function passes(): bool
    {
        try {
            /* @phpstan-ignore-next-line */
            DB::connection()->getPdo();
        } catch (Throwable) {
            return false;
        }

        return true;
    }
}
