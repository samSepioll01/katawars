<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'uri_logo'];

    /**
     * This determinines which katas belongs to a language.
     */
    public function katas(): HasMany
    {
        return $this->hasMany(Kata::class);
    }
}
