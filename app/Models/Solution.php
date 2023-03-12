<?php

namespace App\Models;

use App\Traits\Likeable;
use App\Traits\Punctuable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Solution extends Model
{
    use HasFactory, Likeable, Punctuable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'profile_id',
        'kata_id',
        'code',
        'chrono',
        'end_date',
    ];

    /**
     * This determines the relationship with Favorite class.
     */
    public function favorite(): HasOne
    {
        return $this->hasOne(Favorite::class);
    }

    /**
     * This determines which kata is associated with the solution.
     */
    public function kata(): BelongsTo
    {
        return $this->belongsTo(Kata::class);
    }

    /**
     * This determines the owner profile for the solution.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
