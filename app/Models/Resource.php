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
        'owner_id',
        'kata_id',
    ];

    // RELATIONSHIP METHODS

    /**
     * This determines which profile is the owner of the resource.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'owner_id', 'id');
    }

    /**
     * This determines which kata is associated with the resource.
     */
    public function kata(): BelongsTo
    {
        return $this->belongsTo(Kata::class);
    }
}
