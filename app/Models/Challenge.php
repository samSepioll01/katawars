<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        'title',
        'description',
        'slug',
        'examples',
        'notes',
    ];

    /**
     * This determines which katas are associated to the challenge.
     */
    public function katas(): HasMany
    {
        return $this->hasMany(Kata::class);
    }
}
