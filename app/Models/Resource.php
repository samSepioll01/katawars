<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    use HasFactory, Likeable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'profile_id',
        'kata_id',
    ];

    /**
     * This determines which profile is the owner of the resource.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * This determines which kata is associated with the resource.
     */
    public function kata(): BelongsTo
    {
        return $this->belongsTo(Kata::class);
    }
}
