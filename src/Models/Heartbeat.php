<?php

namespace RWC\Healthful\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $type
 *
 * @method static self firstOrNew(array $attributes = [])
 */
class Heartbeat extends Model
{
    public const PACKAGE_INSTALLED = 1;
    public const JOB               = 2;
    public const SCHEDULE          = 3;

    protected $fillable = ['type'];

    public static function initialization(): Carbon
    {
        return static::query()
            ->where('type', static::PACKAGE_INSTALLED)
            ->first()
            ->created_at;
    }

    public function isOfType(int $type): bool
    {
        return $this->type === $type;
    }
}
