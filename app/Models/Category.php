<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'bg_colow'];

    /**
     * This determines which challenge have a category.
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class);
    }
}
