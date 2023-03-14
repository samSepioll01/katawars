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
     *
     * Comprobar BUG - Sólo permite un registro.
     * Probar si se puede cambiar el profile_id de la relación polimórfica
     * en vez de registrar el propietario, registrar el que da los puntos.
     * Así se prodría acceder al propietario para darle lospuntos mediante
     * el método likeables o algo así.
     */
    public function registerPunctuationTo($votedID = null)
    {
        $votedID = $votedID ?? $this->filterForeignKey();
        $thisID = ($this::class === Kata::class)
            ? $this->owner_id
            : $this->profile_id;

        if ($this->punctuatedBy() || !$this->profileExist($votedID)
            || $votedID !== $thisID ) {
            return false;
        }

        $this->punctuatedByProfiles()->attach($votedID, [
            'punctuation_id' => Punctuation::where(
                'denomination',
                $this->denominations[$this::class]
            )->first()->id,
        ]);
        return true;
    }

    public function assignPunctuationTo(int $votedID = null)
    {
        return false;
    }

    /**
     * Check if a profile has already obtained punctuation
     * for this interaction.
     */
    public function punctuatedBy(int $profileID = null): bool
    {
        return (bool) $this->punctuated()
            ->where('profile_id', $profileID ?? $this->profile_id)
            ->count();
    }

    public function punctuatedCount()
    {
        return false;
    }

    /**
     * Check if the passed profile exist in database.
     */
    private function profileExist(int $profileID): bool
    {
        return Profile::pluck('id')->contains($profileID);
    }

    private function filterForeignKey(): int
    {
        return ($this::class === Kata::class)
            ? $this->owner_id
            : $this->profile_id;
    }
}
