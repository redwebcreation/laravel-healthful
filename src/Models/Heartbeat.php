<?php

namespace RWC\Healthful\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
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
