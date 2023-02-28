<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    use HasFactory;

    /**
     * Set the the relationship with Kata model.
     * This determines which katas were skipped by the users
     * and see their solutions.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function skippedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'skipped_katas');
    }
}
