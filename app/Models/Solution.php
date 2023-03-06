<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solution extends Model
{
    use HasFactory, Likeable;

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
}
