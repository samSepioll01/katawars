<?php

namespace App\Traits;

use App\Models\Profile;
use App\Models\Like;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Likeable
{

    /**
     * Get all likes for a related Likeable model.
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeables');
    }

    /**
     * Get all likes by profiles for a related Likeable model.
     */
    public function likedByProfiles(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'likeables')
            ->as('like')
            ->withTimestamps();
    }

    /**
     * Add a like from a profile for a related Likable model.
     * Return true if successful, false otherwise.
     */
    public function like($profileID = null): bool
    {
        $profileID = $profileID ?? auth()->user()->id;
        $profileExists = Profile::pluck('id')->contains($profileID);

        if ($this->likedBy($profileID) || !$profileExists
            || $profileID === $this->profile_id
        ) {
            return false;
        }

        $this->likes()->attach($profileID);
        return true;
    }

    /**
     * Remove a like from a profile for a related Likeable model.
     * Return 1 if successful, 0 otherwise.
     */
    public function unlike($profileID = null): int
    {
        return $this->likes()->detach($profileID ?? auth()->user()->id);
    }

    /**
     * Check if a profile has linked this related Likeable model.
     */
    public function likedBy($profileID = null): bool
    {
        return (bool) $this->likes()
            ->where('profile_id', $profileID ?? auth()->user()->id)
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
