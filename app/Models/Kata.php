<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kata extends Model
{
    use HasFactory;

    // RELATIONSHIPS METHODS

    /**
     * This determines which solutions are associated with a kata.
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class);
    }

    /**
     * This determines which profiles skipped a Kata.
     */
    public function skippedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'skipped_katas');
    }

    /**
     * This determines which profiles passed with success a Kata.
     */
    public function passedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'solutions')
            ->withPivot('code', 'chrono', 'is_favorite', 'end_date')
            ->withTimestamps();
    }

    /**
     * This determines which profiles were saved a kata in their profile's
     * saved kata list. Sets the relationship
     */
    public function savedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'saved_katas')
            ->withPivot('num_orden')->withTimestamps();
    }

    /**
     * This determines which categories have been assigned to the kata.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * This determines which kumites have been asignned to the kata.
     */
    public function kumites(): HasMany
    {
        return $this->hasMany(Kumite::class);
    }

    // STATIC METHODS.

    /**
     * This determines which profiles passed succesly a kata.
     */
    public static function favorites($id): Collection
    {
        return self::find($id)?->passedByProfiles()->where('is_favorite', true)->get();
    }
}
