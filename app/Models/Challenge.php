<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Challenge extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        'title',
        'description',
        'rank_id',
        'slug',
        'examples',
        'notes',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'examples' => $this->examples,
            'notes' => $this->notes,
            'created_at',
        ];
    }

    /**
     * This determines which katas are associated to the challenge.
     */
    public function katas(): HasMany
    {
        return $this->hasMany(Kata::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * This determines which categories have been assigned to the challenge.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

     /**
     * This determines which rank was assigned to the challenge.
     */
    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * Filter the challenges throught passed filters on a query.
     *
     * @param mixed $query
     * @param array $filters
     * @param array|null $modes
     */
    public function scopeFilter($query, array $filters, array $modes = null)
    {
        // Sanitize the params for apply the filters
        $rank = $filters['rank'] ?? false;
        $rank = $rank === 'ranks' ? false : $rank;
        if (!Rank::pluck('name')->contains($rank)) $rank = false;

        $category = $filters['category'] ?? false;
        $category = $category === 'null' ? false : $category;
        if (!Category::pluck('name')->contains($category)) $category = false;

        $modes = $modes ?? Mode::pluck('id');

        // Filter data throught relationship values and if the param is omitted
        // not apply the filter, therefore, recovery all the records in his scope.
        return Challenge::query()
            ->when($category ?? false, fn($query, $category) =>
                $query->whereHas('categories', fn($query) =>
                    $query->where('name', $category)
                )
            )
            ->when($rank, fn($query, $rank) =>
                $query->whereHas('rank', fn($query) =>
                    $query->where('name', $rank)
                )
            )
            ->when(true, fn($query) =>
                $query->whereHas('katas', fn($query) =>
                    $query->whereIn('mode_id', $modes)
                )
            );
    }
}
