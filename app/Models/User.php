<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Socialite\Two\User as GitHubUser;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable,
        TwoFactorAuthenticatable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_photo_path',
        'github_id',
        'github_repos_url',
        'github_token',
        'github_refresh_token',
        'github_expires_in',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'github_token',
        'github_refresh_token',
        'github_expires_in',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * This determines which profile is associated to the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'id');
    }

    /**
     * Generate a unique name in the application.
     * @param string|null $name
     * @param GitHubUser $user
     * @return string $res
     */
    public static function generateUniqueName(
        string $name = null,
        GitHubUser|null $githubUser = null
    ): string
    {
        $faker = Faker::create();
        $name = $name ?? str_replace([' ', '.'], '', $faker->name());
        $res = '';
        $user = auth()->user();
        $salt = (2 * pow(pi(), 2));

        $seed = $githubUser?->getId() + $user?->id + now()->valueOf() * $salt;

        // Generate a username by searching for the first available occurrence
        // by incrementally cutting the seed.
        if (self::where('name', $name)->exists()) {
            for ($i = 1; $i < 15; $i++) {
                $res = $name . substr( (string) $seed, 0, $i);
                if (self::where('name', $res)->doesntExist()) {
                    break;
                }
            }
        } else {
            $res = $name;
        }

        // Case in which the loop ends and there are still matching records.
        if (self::where('name', $res)->exists()) {
            $counter = 0;
            while (self::where('name', $res)->exists()) {

                if ($counter < 10) {
                    $code = substr(Hash::make($res), 7, 23);
                } else {
                    $code = substr(Hash::make($res), 7);
                }
                $res = $name . str_replace(['.', '/'], '', $code);
                $counter++;
            }
        }

        // Sanitize the generated string by setting the lenght
        // constraint for that field.
        if (strlen($res) > 255) {
            $res = substr($res, 0, 250);
            if (self::where('name', $res)->exists()) {
                $res = Hash::make($res);
            }
        }

        return $res;
    }
}
