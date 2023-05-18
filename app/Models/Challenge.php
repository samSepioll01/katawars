<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    use HasFactory;

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
     * This determines which katas are associated to the challenge.
     */
    public function katas(): HasMany
    {
        return $this->hasMany(Kata::class);
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

    public function scopeFilter($query, array $filters, array $modes = null)
    {
        $rank = $filters['rank'] ?? false;
        $rank = $rank === 'ranks' ? false : $rank;
        if (!Rank::pluck('name')->contains($rank)) $rank = false;

        $category = $filters['category'] ?? false;
        $category = $category === 'null' ? false : $category;
        if (!Category::pluck('name')->contains($category)) $category = false;

        $modes = $modes ?? Mode::pluck('id');

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
