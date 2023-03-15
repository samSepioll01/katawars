<?php

namespace App\Traits;

use App\Models\Kata;
use App\Models\Profile;
use App\Models\Punct;
use App\Models\Punctuation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Punctuable
{
    private $denominations = [
        'App\Models\Solution' => 'likes',
        'App\Models\Resource' => 'likes',
        'App\Models\Favorite' => 'add-favorites',
    ];

    /**
     * Get all punctuations for a related Punctuable model.
     */
    public function punctuated(): MorphMany
    {
        return $this->morphMany(Punct::class, 'punctuables');
    }

    /**
     * Get all registers that have been punctuated by the profiles.
     */
    public function punctuatedByProfiles(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'punctuables')
            ->withPivot(['punctuation_id'])
            ->withTimestamps();
    }

    /**
     * Set the punctuation for a punctuable interaction.
     * Return true if the operation was succesfull, false otherwise.
     */
    public function registerPunctuationTo(int $voterID = null)
    {
        $voterID = $voterID ?? auth()->user()->id;

        if ($this->punctuatedBy($voterID) || !$this->profileExist($voterID)
            || $voterID === $this->selectForeignKey() ) {
            return false;
        }

        $this->punctuatedByProfiles()->attach($voterID, [
            'punctuation_id' => Punctuation::where(
                'denomination',
                $this->denominations[$this::class]
            )->first()->id,
        ]);
        return true;
    }

    public function assignPunctuationTo(int $voterID = null)
    {
        return false;
    }

    /**
     * Check if a voter profile has already given punctuation
     * for this interaction.
     */
    public function punctuatedBy(int $voterID = null): bool
    {
        return (bool) $this->punctuated()
            ->where('profile_id', $voterID ?? auth()->user()->id)
            ->count();
    }

    public function punctuatedCount()
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
