<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    use HasFactory;

    /**
     * This determines which katas were skipped by the users
     * and see their solutions.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function skippedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'skipped_katas');
    }

    /**
     * This determines which katas were passed with success by the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function solutions(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'solutions');
    }

    /**
     * This determines which profiles were blocked by the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function blockedProfiles(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'blocked_profiles', 'profile_id', 'blocked_id'
        );
    }

    /**
     * This determines which profiles blocked the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function blockers(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'blocked_profiles', 'blocked_id', 'profile_id'
        );
    }

    /**
     * This determines which profiles follow the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function followers()
    {
        return $this->belongsToMany(
            Profile::class, 'followers', 'profile_id', 'follower_id'
        );
    }

    /**
     * This determines which profiles are followed by the user.
     */
    public function following()
    {
        return $this->belongsToMany(
            Profile::class, 'followers', 'follower_id', 'profile_id'
        );
    }
}
