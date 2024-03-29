<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kata extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'challenge_id',
        'owner_id',
        'language_id',
        'mode_id',
        'uri_test',
        'signature',
        'testClassName',
    ];

    /**
     * This determines which challenge is associated to the kata.
     * Challenge model contains the title, description, slug for the kata.
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * This determines which profile is the owner of the kata.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'owner_id', 'id');
    }

    /**
     * This determines which mode was assigned to the kata.
     */
    public function mode(): BelongsTo
    {
        return $this->belongsTo(Mode::class);
    }

    /**
     * This determines which language was assigned to the kata.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * This determines which video solution was assigned to the kata.
     */
    public function video(): HasOne
    {
        return $this->hasOne(VideoSolution::class);
    }

    /**
     * This determines the resources that have been published in the kata.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * This determines which solutions are associated with a kata.
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class);
    }

    /**
     * This determines which profiles skipped a Kata.
     */
    public function skippedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'skipped_katas');
    }

    /**
     * This determines which profiles passed with success a Kata.
     */
    public function passedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'solutions')
            ->withPivot('code', 'chrono', 'end_date')
            ->withTimestamps();
    }

    /**
     * This determines which profiles were saved a kata in their profile's
     * saved kata list. Sets the relationship
     */
    public function savedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'saved_katas')
            ->withPivot('num_orden')->withTimestamps();
    }

    /**
     * This determines which kumites have been asignned to the kata.
     */
    public function kumites(): HasMany
    {
        return $this->hasMany(Kumite::class);
    }

    /**
     * This determines which katas was assigned to the kataways.
     */
    public function assignedToKataways(): BelongsToMany
    {
        return $this->belongsToMany(Kataway::class);
    }
}
