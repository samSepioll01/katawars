<?php

namespace App\Traits;

use App\Models\Favorite;
use App\Models\Kata;
use App\Models\Profile;
use App\Models\Resource;
use App\Models\Score;
use App\Models\ScoreRecord;
use App\Models\Solution;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Scoreable
{
    private $denominations = [
        'App\Models\Solution' => 'like',
        'App\Models\Resource' => 'like',
        'App\Models\Favorite' => 'add favorites',
    ];

    /**
     * Get all punctuations for a related scoreable model.
     */
    public function scores(): MorphMany
    {
        return $this->morphMany(ScoreRecord::class, 'scoreables');
    }

    /**
     * Get all registers that have been scored by the profiles.
     */
    public function scoredByProfiles(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'scoreables')
            ->withPivot(['score_id'])
            ->withTimestamps();
    }

    /**
     * Set the punctuation for a scoreable interaction.
     * Return true if the operation was succesfull, false otherwise.
     */
    public function createScoreRecord(int $voterID = null)
    {
        $voterID = $voterID ?? auth()->user()->id;

        if ($this->scoredBy($voterID) || !$this->profileExist($voterID)
            || $voterID === $this->selectForeignKey() ) {
            return false;
        }

        $this->scoredByProfiles()->attach($voterID, [
            'score_id' => Score::where(
                'denomination',
                $this->denominations[$this::class]
            )->first()->id,
        ]);
        return true;
    }

    /**
     * Assign the score to the owner of the entity on which the interaction
     * is performed.
     */
    public function assignScore(): bool
    {
        $profile = Profile::find($this->selectForeignKey());
        $profile->honor += Score::where(
            'denomination',
            $this->denominations[$this::class]
        )
        ->first()
        ->points;
        $profile->save();

        return true;
    }

    /**
     * Check if a voter profile has already given punctuation
     * for this interaction.
     */
    public function scoredBy(int $voterID = null): bool
    {
        return (bool) $this->scores()
            ->where('profile_id', $voterID ?? auth()->user()->id)
            ->count();
    }

    /**
     * Get the number of scored records for this related Scoreable model.
     */
    public static function scoredCount($modelID = null): int | null
    {
        return self::withCount('scores')->find($modelID)?->scores_count;
    }

    /**
     * Check if the passed voter profile exist in database.
     */
    public function profileExist(int $voterID): bool
    {
        return Profile::pluck('id')->contains($voterID);
    }

    /**
     * This determines which identifier select depending on the model used.
     */
    public function selectForeignKey()
    {
        return [
            Favorite::class => $this->solution->kata->owner_id,
            Resource::class => $this->profile_id,
            Solution::class => $this->profile_id,
        ][$this::class];
    }
}
