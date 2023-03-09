<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VideoSolution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'youtube_code',
        'kata_id',
    ];

    /**
     * This determines which kata was assigned to the video salution.
     */
    public function kata(): HasOne
    {
        return $this->hasOne(Kata::class);
    }
}
