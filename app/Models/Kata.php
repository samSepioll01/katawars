<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kata extends Model
{
    use HasFactory;

    // RELATIONSHIPS METHODS

    /**
     * This determines which profiles skipped a Kata.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function skippedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'skipped_katas');
    }

    /**
     * This determines which profiles passed with success a Kata.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function passedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'solutions')
            ->withPivot('code', 'chrono', 'is_favorite', 'start_date', 'end_date');
    }

    // STATIC METHODS.

    /**
     * This determines which profiles passed succesly a kata.
     */
    public static function favorites($id)
    {
        return self::find($id)?->passedByProfiles()->where('is_favorite', true)->get();
    }
}
