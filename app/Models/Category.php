<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'bg_color'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'bg_color' => $this->bg_color,
            'created_at' => $this->created_at,
        ];
    }

    /**
     * This determines which challenge have a category.
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class);
    }
}
