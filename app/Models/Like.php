<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    /**
     * The name of the table for the related model.
     *
     * @var string
     */
    protected $table = 'likeables';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'profile_id',
        'likeables_type',
        'likeables_id',
    ];

    /**
     * This determines which profile has given the like.
     */
    public function profile()
    {
        return $this->belongsTo(
            Profile::class, 'profile_id', 'id', $this->table
        );
    }

    /**
     * This determines the type of entity over wich the profile has liked.
     */
    public function likeable()
    {
        return $this->morphTo($this->table);
    }
}
