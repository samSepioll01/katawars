<?php

namespace App\Traits;

use App\Models\Kata;
use App\Models\Profile;
use App\Models\Score;
use App\Models\ScoreRecord;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Scoreable
{
    private $denominations = [
        'App\Models\Solution' => 'likes',
        'App\Models\Resource' => 'likes',
        'App\Models\Favorite' => 'add-favorites',
    ];

    /**
     * Get all punctuations for a related Punctuable model.
     */
    public function scores(): MorphMany
    {
        return $this->morphMany(ScoreRecord::class, 'scoreables');
    }

    /**
     * Get all registers that have been punctuated by the profiles.
     */
    public function scoredByProfiles(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'scoreables')
            ->withPivot(['score_id'])
            ->withTimestamps();
    }

    /**
     * Set the punctuation for a punctuable interaction.
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

    public function assignScoreTo(int $voterID = null)
    {
        return false;
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

    public function scoresCount()
    {
        return false;
    }

    /**
     * Check if the passed voter profile exist in database.
     */
    private function profileExist(int $voterID): bool
    {
        return Profile::pluck('id')->contains($voterID);
    }

    private function selectForeignKey(): int
    {
        return ($this::class === Kata::class)
            ? $this->owner_id
            : $this->profile_id;
    }
}
