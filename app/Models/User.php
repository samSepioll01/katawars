<?php

namespace App\Models;

use Carbon\Carbon;
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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Features;
use Laravel\Scout\Searchable;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable,
        TwoFactorAuthenticatable, HasRoles, SoftDeletes, Searchable;

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
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'created_at' => $this->created_at,
        ];
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Override public disk configuration to s3, otherwise hold it.
        $disk = config('jetstream.profile_photo_disk') !== 'public' ?: 's3';

        $url = $this->profile_photo_path
                    ? Storage::disk($disk)
                        ->url($this->profile_photo_path)
                    : $this->defaultProfilePhotoUrl();

        // Validate GitHub Sync Profile Photo Case
        if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
            if ( substr_count( $url, 'http') > 1 ) {
                $url = $this->profile_photo_path;
            }
        }

        return $url;
    }

    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo)
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->store(
                    'profile-photos/' . $this->id, ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto(string $disk = null)
    {
        $disk = $disk ?? $this->profilePhotoDisk();
        $path = str_replace(
            env('AWS_PROFILE_URL'), '', $this->profile_photo_path
        );

        if (! Features::managesProfilePhotos()) {
            return;
        }

        if (is_null($this->profile_photo_path)) {
            return;
        }

        Storage::disk($disk)->delete($path);
    }

    /**
     * This determines the historial sessions for the user.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * This determines if the passed user is online.
     *
     * @param \App\Models\User|null $user
     * @return bool Return true if the user is online, false otherwise.
     */
    public static function isOnline(User $user = null): bool
    {
        return $user
            ? (bool) Session::all()->where('user_id', $user->id )->count()
            : false;
    }

    /**
     * This determines the last activity for a user.
     *
     * @return string Online if the current user is Online in this moment,
     *                the time since the last connection.
     */
    public function last_activity()
    {
        return self::isOnline($this)
            ? 'Online'
            : (new Carbon($this->profile->last_activity))->diffForHumans(now());
    }

    /**
     * This determines the position in the global ranking for the users.
     * Excluding admins users.
     *
     * @return int
     */
    public function ranking()
    {
        $ranking = Profile::whereHas('user', fn($query) => $query->role('user'))
            ->orderByDesc('exp')->orderByDesc('honor')->get();

        $userRanking = $ranking->search($ranking->find($this->id)) + 1;

        return $this->hasRole(['superadmin', 'admin'])
            ? 'Sannin'
            : $userRanking;
    }

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
                $res = $name . substr( (string) $seed, 8);
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
