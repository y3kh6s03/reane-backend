<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'skill_id',
        'reach_id',
        'is_completed',
    ];

    protected static function booted()
    {
        static::creating(function ($action) {
            $action->reach->touch();
        });

        static::updating(function ($action) {
            $action->reach->touch();
        });

        static::deleting(function ($action) {
            $action->reach->touch();
        });
    }

    public function reach(): BelongsTo
    {
        return $this->belongsTo(Reach::class);
    }
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
