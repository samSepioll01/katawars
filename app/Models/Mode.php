<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['denomination'];

    /**
     * This determines which katas belongs to a mode.
     */
    public function katas(): HasMany
    {
        return $this->hasMany(Kata::class);
    }
}
