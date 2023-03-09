<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kumite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'profile_id',
        'kata_id',
        'opponent_id',
        'winner_id',
    ];

    /**
     * This determines which profile has been assigned.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * This determines which profile it must against compete.
     */
    public function opponent(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'opponent_id', 'id', 'kumites');
    }

    /**
     * This determines which profiles were facing each other.
     */
    public function opponents(): BelongsTo
    {
        return $this->profile()->union($this->opponent());
    }

    /**
     * This determines which profile won the kumite.
     */
    public function winner(): BelongsTo | null
    {
        return $this->belongsTo(Profile::class, 'winner_id', 'id', 'kumites');
    }

    /**
     * This determines which kata has been assigned to the kumite.
     */
    public function kata(): BelongsTo
    {
        return $this->belongsTo(Kata::class);
    }
}
