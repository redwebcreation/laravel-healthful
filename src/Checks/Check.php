<?php

namespace RWC\Healthful\Checks;

interface Check
{
    public function passes(): bool;
}
