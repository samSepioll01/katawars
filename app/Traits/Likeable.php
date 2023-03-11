<?php

namespace App\Traits;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Likeable
{

    /**
     * Get all likes for a realted Likeable model.
     */
    public function likes(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'likeables')
            ->withTimestamps();
    }

    /**
     * Add a like from a profile for a related Likable model.
     * Return true if successful, false otherwise.
     */
    public function like($profile = null): bool
    {
        $profile = $profile ?? auth()->user();
        $profileExists = Profile::pluck('id')->contains($profile);

        if ($this->likedBy($profile) || !$profileExists) {
            return false;
        }

        $this->likes()->attach($profile);
        return true;
    }

    /**
     * Remove a like from a profile for a related Likeable model.
     * Return 1 if successful, 0 otherwise.
     */
    public function unlike($profile = null): int
    {
        return $this->likes()->detach($profile ?? auth()->user());
    }

    /**
     * Check if a profile has linked this related Likeable model.
     */
    public function likedBy($profile = null): bool
    {
        return (bool) $this->likes()
            ->where('profile_id', $profile ?? auth()->user())
            ->count();
    }

    /**
     * Get the number of likes for this related Likeable model.
     */
    public static function likesCount($modelID = null): int | null
    {
        return self::withCount('likes')->find($modelID)?->likes_count;
    }

    /**
     * Get all likes sorted by number of likes for this related Likeable model.
     */
    public static function allLikesCount(): Collection
    {
        return self::withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->get();
    }

    /**
     * Delete all likes for an instance of the related Likeable model.
     * Return an integer that indicates the number of affected records.
     */
    public function removeAllLikes(): int
    {
        return $this->likes()->detach();
    }
}
