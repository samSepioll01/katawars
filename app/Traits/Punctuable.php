<?php

namespace App\Traits;

use App\Models\Profile;
use App\Models\Punctuation;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Punctuable
{

    private $denominations = [
        'App\Models\Solution' => 'likes',
    ];

    /**
     * Get all registers that have been punctuated previously.
     */
    public function punctuated(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'punctuables')
            ->withPivot(['punctuation_id'])
            ->withTimestamps();
    }

    public function assignPunctuationTo($profileID = null)
    {
        $profileID = $profileID ?? $this->profile_id;

        $this->punctuated()->attach($profileID, [
            'punctuation_id' => Punctuation::where(
                'denomination',
                $this->denominations[$this::class]
            )->first()->id,
        ]);
        return true;
    }
}
