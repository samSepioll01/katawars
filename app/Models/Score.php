<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Score extends Model
{
    use HasFactory, Searchable;

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
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'denomination' => $this->denomination,
            'type' => $this->type,
            'points' => $this->points,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
