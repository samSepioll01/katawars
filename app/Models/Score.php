<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'denomination',
        'type',
        'points'
    ];

    /**
     * This determines all the punctuated records order by punctuation class.
     */
    public function scoredByClass()
    {
        return $this->hasMany(Punct::class);
    }
}
