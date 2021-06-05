<?php

namespace RWC\Healthful\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $type
 *
 * @method static self firstOrNew(array $attributes = [])
 */
class Heartbeat extends Model
{
    public const JOB      = 1;
    public const SCHEDULE = 2;

    protected $fillable = ['type'];

    public function isOfType(int $type): bool
    {
        return $this->type === $type;
    }
}
