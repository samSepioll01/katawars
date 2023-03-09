<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'exp',
        'honor',
        'is_darkmode',
        'is_deleted',
        'is_banned',
        'rank_id',
    ];

    // RELATIONSHIPS METHODS

    /**
     * This determines which user is associated to the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * This determines the actual rank of the profile.
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * This determines which katas belongs to the profile.
     */
    public function ownerKatas()
    {
        return $this->hasMany(Kata::class);
    }

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
     */
    public static function toggleKataToFavorites(
        int $profileID = null,
        int $kataID = null,
    ): void
    {
        $solution = self::find($profileID ?? auth()->user()->id)
                            ?->passedKatas()->find($kataID)?->pivot;
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
     * This determines which kumites were competed for the profile.
     */
    public function kumites(): HasMany
    {
        return $this->hasMany(Kumite::class);
    }

    /**
     * This determines which opponents were facing against the profile.
     */
    public function opponents(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'kumites', 'profile_id', 'opponent_id'
        );
    }

    /**
     * This determines which kumites was won by the profile.
     */
    public function wonKumites(): HasMany
    {
        return $this->kumites()->where('winner_id', $this->id);
    }

    /**
     * This determines which kumites was lost by the profile.
     */
    public function lostKumites(): HasMany
    {
        return $this->kumites()->where('winner_id', '!=', $this->id);
    }

    /**
     * This determines which rival has obtained more victories against
     * the profile.
     */
    public function beastOpponent(): Collection
    {
        return $this->lostKumites()
		        ->select(
                    "kumites.opponent_id",
                    DB::raw("count(*) as total_lost"),
                )
		        ->groupBy("opponent_id")
		        ->havingRaw(
                    "count(*) >= all (
                        select count(*)
					      from profiles
                          join kumites on profiles.id = kumites.profile_id
					     where profiles.id = ?
					       and kumites.winner_id != ?
				      group by opponent_id
                    )", [ $this->id, $this->id ]
		        )
		->get();
    }

    /**
     * This determines against which rival the profile has obtained more
     * victories.
     */
    public function beastRivalFor(): Collection
    {
        return $this->wonKumites()
                ->select(
                    "kumites.opponent_id",
                    DB::raw("count(*) as total_victories"),
                )
                ->groupBy("opponent_id")
                ->havingRaw(
                    "count(*) >= all (
                        select count(*)
                          from profiles
                          join kumites on profiles.id = kumites.profile_id
                         where profiles.id = ?
                           and kumites.winner_id = ?
                      group by opponent_id
                    )", [ $this->id, $this->id ]
                )
        ->get();
    }

    /**
     * This dertermines which kataways was started by the profile.
     */
    public function startedKataways(): BelongsToMany
    {
        return $this->belongsToMany(Kataway::class)
            ->withPivot(['end_date']);
    }

    /**
     * This determines which kataways was completed by the profile.
     */
    public function completedKataways(): Collection
    {
        return $this->startedKataways()->get()
            ->filter(fn($kataway) => $kataway->pivot->end_date)
            ->values();
    }
}
