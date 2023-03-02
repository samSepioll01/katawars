<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Solution extends Model
{
    use HasFactory;

    /**
     * This determines if the solution has ever been
     * in the profile favorites list.
     *
     * @return boolean Return true if solution has ever been as favorite,
     *                 false otherwise.
     */
    public function hasEverBeenAsFavorite()
    {
        return $this->hasOne(Favorite::class)?->first() ? true : false;
    }

    /**
     * This determines which kata is associated with the solution.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kata(): BelongsTo
    {
        return $this->belongsTo(Kata::class);
    }
}
