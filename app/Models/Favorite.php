<?php

namespace App\Models;

use App\Traits\Scoreable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory, Scoreable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['profile_id', 'solution_id', 'is_active'];

    /**
     * This determine which profile is associated with a favorite.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * This determines which solution is associated with a favorite.
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class, 'solution_id', 'id', 'solutions');
    }

    /**
     * This determines which score record was created when the profile
     * added the resource to his favorite list.
     */
    public function scoreRecords()
    {
        return $this->morphMany(ScoreRecord::class, 'scoreables');
    }
}
