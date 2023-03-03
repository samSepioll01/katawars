<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use HasFactory;

    // RELATIONSHIPS METHODS

    /**
     * This determines which katas were skipped by the users
     * and see their solutions.
     */
    public function skippedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'skipped_katas');
    }

    /**
     * This determines which katas were passed with success by the user.
     */
    public function passedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'solutions')
            ->withPivot('code', 'chrono', 'is_favorite', 'end_date')
            ->withTimestamps();
    }

    /**
     * This determines which profiles were blocked by the user.
     */
    public function blockedProfiles(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'blocked_profiles', 'profile_id', 'blocked_id'
        );
    }

    /**
     * This determines which profiles blocked the user.
     */
    public function blockers(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'blocked_profiles', 'blocked_id', 'profile_id'
        );
    }

    /**
     * This determines which profiles follow the user.
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
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'followers', 'follower_id', 'profile_id'
        );
    }

    /**
     * This determines which katas the user has in their favorites list.
     */
    public function favorites(): Collection
    {
        return $this->passedKatas()->where('is_favorite', true)->get();
    }

    /**
     * This add/remove a kata from profile's favorites list.
     * MUST BE MODIFICATED FOR PRODUCTION ENVIRONTMENT.
     * $profileID MUST BE CHANGED FOR auth()->user()->id VALUE.
     */
    public static function toggleKataToFavorites(int $profileID, int $kataID): void
    {
        $solution = self::find($profileID)?->passedKatas()->find($kataID)?->pivot;
        $solution->is_favorite = !$solution->is_favorite;
        $solution->save();
    }

    /**
     * This determines which solutions katas has ever been in profile's favorite
     * list.
     */
    public function profileFavoritesHistory(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * This determines which katas has been saved in the profile's saved kata list.
     * Set the relationship using saved_katas pivot table.
     */
    public function savedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'saved_katas')
            ->withPivot('num_orden')->withTimestamps();
    }

    /**
     * This determines the likes that the profile gave to solutions of other profiles.
     */
    public function likesGivenToSolutions(): BelongsToMany
    {
        return $this->belongsToMany(Solution::class, 'solutions');
    }
}
