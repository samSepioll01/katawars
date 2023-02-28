<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kata extends Model
{
    use HasFactory;

    /**
     * Set the relationship with Profile model.
     * This determines which profiles skipped a Kata.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function skippedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'skipped_katas');
    }
}
