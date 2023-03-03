<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Solution extends Model
{
    use HasFactory;

    /**
     * This determines if the solution has ever been in the profile favorites list.
     */
    public function hasEverBeenAsFavorite(): bool
    {
        return $this->hasOne(Favorite::class)?->first() ? true : false;
    }

    /**
     * This determines which kata is associated with the solution.
     */
    public function kata(): BelongsTo
    {
        return $this->belongsTo(Kata::class);
    }

    /**
     * This determines which profiles liked the solution.
     */
    public function likedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class);
    }
}
