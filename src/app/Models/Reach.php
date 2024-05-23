<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reach extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "user_name",
        "user_email",
        "user_image",
    ];

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }
}
