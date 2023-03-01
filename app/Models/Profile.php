<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    use HasFactory;


    // RELATIONSHIPS METHODS

    /**
     * This determines which katas were skipped by the users
     * and see their solutions.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function skippedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'skipped_katas');
    }

    /**
     * This determines which katas were passed with success by the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function passedKatas(): BelongsToMany
    {
        return $this->belongsToMany(Kata::class, 'solutions')
            ->withPivot('code', 'chrono', 'is_favorite', 'start_date', 'end_date');
    }

    /**
     * This determines which profiles were blocked by the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function blockedProfiles(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'blocked_profiles', 'profile_id', 'blocked_id'
        );
    }

    /**
     * This determines which profiles blocked the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function blockers(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class, 'blocked_profiles', 'blocked_id', 'profile_id'
        );
    }

    /**
     * This determines which profiles follow the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongToMany
     */
    public function followers()
    {
        return $this->belongsToMany(
            Profile::class, 'followers', 'profile_id', 'follower_id'
        );
    }

    /**
     * This determines which profiles are followed by the user.
     */
    public function following()
    {
        return $this->belongsToMany(
            Profile::class, 'followers', 'follower_id', 'profile_id'
        );
    }

    // STATIC METHODS.

    /**
     * This determines which katas the user has in their favorites list.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function favorites($id)
    {
        return self::find($id)->passedKatas()->where('is_favorite', true)->get();
    }

    /**
     * This add/remove a kata from profile's favorites list.
     */
    public static function toggleKataToFavorites($profileID, $kataID, $add = true)
    {
        $solution = self::find($profileID)?->passedKatas()->find($kataID)?->pivot;
        $solution->is_favorite = $add;
        $solution->save();

        return $solution ? true : false;
    }

    /**
     * TODO - Implentar la comprobación de la tabla has_been_favorito que no podrá
     *        ser modificada porque su objetivo es cuando se le de un favorito a una
     *        solución conste en ella siempre para que no se le vuelvan a sumar los puntos.
     *        Pensar si no es mejor implementarlo con un campo en solutions table al igual
     *        que is_favorite.
     */
    public function hasBeenFavorite()
    {

    }

}
