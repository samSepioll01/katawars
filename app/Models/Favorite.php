<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    /**
     * This determine which profile is associated with a favorite.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * This determines which solution is associated with a favarite.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class, 'solution_id', 'id', 'solutions');
    }
}
