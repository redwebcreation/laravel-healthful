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
    public const INITIALIZATION    = 1;
    public const JOB               = 2;
    public const SCHEDULE          = 3;

    protected $fillable = ['type'];

    public static function initialization(): Carbon
    {
        /* @phpstan-ignore-next-line */
        return self::query()
                ->where('type', static::INITIALIZATION)
                ->first()->created_at ?? now()->year(1);
    }

    public function isOfType(int $type): bool
    {
        return $this->type === $type;
    }
}
