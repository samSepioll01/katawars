<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Rank extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'level_up'];


     /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'level_up' => $this->level_up,
            'created_at' => $this->created_at,
        ];
    }

    /**
     * This determines which challenges was assigned to the rank.
     */
    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    /**
     * This determines which profiles was assigned to the rank.
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
