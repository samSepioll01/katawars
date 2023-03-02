<?php

namespace App\Models;

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
    public function passedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'solutions')
            ->withPivot('code', 'chrono', 'is_favorite', 'end_date')
            ->withTimestamps();
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
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'followers', 'follower_id', 'profile_id'
        );
    }

    /**
     * This determines which katas the user has in their favorites list.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function favorites()
    {
        return $this->passedKatas()->where('is_favorite', true)->get();
    }

    /**
     * This add/remove a kata from profile's favorites list.
     * MUST BE MODIFICATED FOR PRODUCTION ENVIRONTMENT.
     * $profileID MUST BE CHANGED FOR auth()->user()->id VALUE.
     *
     * @return void
     */
    public static function toggleKataToFavorites($profileID, $kataID)
    {
        $solution = self::find($profileID)?->passedKatas()->find($kataID)?->pivot;
        $solution->is_favorite = !$solution->is_favorite;
        $solution->save();
    }

    /**
     * This determines which solutions katas has ever been in profile's favorite list.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profileFavoritesHistory(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
