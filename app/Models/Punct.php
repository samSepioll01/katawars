<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Punct extends Model
{
    use HasFactory;

    /**
     * The name of the table for the related model.
     * @var string
     */
    protected $table = 'punctuables';

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'profile_id',
        'likeables_type',
        'likeables_id',
        'punctuation_id',
    ];

    /**
     * This determines which profile has obtained the points.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(
            Profile::class, 'profile_id', 'id', $this->table
        );
    }

    /**
     * This determines the punctuation assigned to an interaction.
     */
    public function punctuation(): BelongsTo
    {
        return $this->belongsTo(Punctuation::class);
    }

    /**
     * This determines the type of entity which obtained the points.
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo($this->table);
    }
}
