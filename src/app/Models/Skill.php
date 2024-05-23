<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "reach_id"
    ];

    public function reach(): BelongsTo
    {
        return $this->belongsTo(Reach::class);
    }
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }
}
