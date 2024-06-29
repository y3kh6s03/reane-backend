<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Journal extends Model
{
    protected $fillable = [
        'reach_id',
        'skill_id',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($journal) {
            $journal->reach->touch();
        });

        static::updating(function ($journal) {
            $journal->reach->touch();
        });

        static::deleting(function ($journal) {
            $journal->reach->touch();
        });
    }

    public function reach(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class, 'action_journal')->withTimestamps();
    }

    use HasFactory;
}
