<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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
    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * This determines which resources have been published by the profile.
     */
    public function publishedResources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * This determiens the likes that the profile have been given to the resources.
     */
    public function likesGivenToResources(): MorphToMany
    {
        return $this->morphedByMany(Resource::class, 'likeables')
            ->withTimestamps();
    }

    /**
     * This determines the likes that profile have been given to the solutions.
     */
    public function likesGivenToSolutions(): MorphToMany
    {
        return $this->morphedByMany(Solution::class, 'likeables')
            ->withTimestamps();
    }

    /**
     * This determines the solutions of the profile.
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class);
    }

    /**
     * This determines which katas belongs to the profile.
     */
    public function ownerKatas(): HasMany
    {
        return $this->hasMany(Kata::class, 'owner_id', 'id');
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
            ->as('solution')
            ->withPivot('code', 'chrono', 'end_date')
            ->withTimestamps();
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
     * Gets a certain number of saved elements manually sorted by the profile.
     * If savedKataID is omitted, it return a Collection. Kata otherwise.
     */
    public static function getSavedKatas(
        int|bool $savedKataID = false,
        int $num_elem = -1,
        string $pivotOrd = 'num_orden',
        string $pivotDir = 'asc',
    ): BelongsToMany | Kata | bool
    {
        $target = self::find(auth()?->user()?->id)?->savedKatas();

        if (!$target) return false;

        return ($savedKataID)
            ? $target->find($savedKataID)
            : $target->take($num_elem)
                     ->orderByPivot($pivotOrd, $pivotDir);
    }

    /**
     * This determines which katas the user has in their favorites list.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
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
        return $this->prepareQuery(
            $this->lostKumites(),'total_lost', '!='
        )->get();
    }

    /**
     * This determines against which rival the profile has obtained more
     * victories.
     */
    public function mostWinsAgainst(): Collection
    {
        return $this->prepareQuery(
            $this->wonKumites(), 'total_wins', '='
        )->get();
    }

    /**
     * This determines the custom queries to be used in the beastOpponent()
     * and mostWinsAgainst() methods.
     */
    private function prepareQuery(
        HasMany $query, string $slug, string $op,
    ): HasMany
    {
        return $query->select(
            "kumites.opponent_id",
            DB::raw("count(*) as $slug"),
        )
        ->groupBy("opponent_id")
        ->havingRaw(
            "count(*) >= all (
                select count(*)
                    from profiles
                    join kumites on profiles.id = kumites.profile_id
                    where profiles.id = ?
                    and kumites.winner_id $op ?
                group by opponent_id
            )", [ $this->id, $this->id ]
        );
    }

    /**
     * This determines the head-to-head record of kumite fighters that have
     * a profile against a particular opponent.
     */
    public function headToHeadRecord(int $opponentID): array
    {
        $applySentences = function($query, $slug) use ($opponentID) {
            return $query->select(
                'opponent_id',
                DB::raw(("count(*) as $slug"))
            )
            ->where('opponent_id', $opponentID)
            ->groupBy('opponent_id')
            ->first()
            ->$slug ?? 0;
        };

        $opponent = Profile::with(['user', 'rank'])->find($opponentID);

        return [
            'wins' => $applySentences($this->wonKumites(), 'total_wins'),
            'lost' => $applySentences($this->lostKumites(), 'total_lost'),
            'opponentInfo' => [
                'name' => $opponent->user()->first()->name,
                'userPhoto' => $opponent->user()->first()->profile_photo_path,
                'rank' => $opponent->rank()->first()->name,
                'exp' => $opponent->exp,
                'honor' => $opponent->honor,
            ],
        ];
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
