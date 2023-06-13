<?php

namespace App\Models;

use App\Traits\Scoreable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Kataway extends Model
{
    use HasFactory, Searchable, Scoreable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        'slug',
        'title',
        'description',
        'uri_image',
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    // RELATIONSHIPS METHODS

    /**
     * This determines which katas belongs to kataway.
     */
    public function katas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class);
    }

    /**
     * This determines the owner of the kataway.
     */
    public function createdByProfile()
    {
        return $this->belongsTo(Profile::class, 'owner_id', 'id');
    }

    /**
     * This determines which profiles were started the kataway.
     */
    public function startedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class)
            ->withPivot(['end_date']);
    }

    /**
     * This determines which profiles were completed the kataway.
     */
    public function completedByProfiles()
    {
        return $this->startedByProfiles()->get()
            ->filter(fn($kataway) => $kataway->pivot->end_date)
            ->values();
    }

    // STATIC METHODS

    public static function isCompleteByProfile(
        $katawayID,
        $profileID = null,
    )
    {
        $profileID = $profileID ?? auth()->user()->id;
        $katawayKatas = self::find($katawayID)?->katas()->pluck('kata_id');
        $passedKatas = $katawayKatas->intersect(
            Profile::find($profileID)->passedKatas()->pluck('kata_id')
        );

        return $katawayKatas->every(
            fn($katawayKata) => $passedKatas->contains($katawayKata)
        );
    }
}
