<?php

namespace App\CustomClasses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;

class S3 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'S3';
    }

    /**
     * Get S3 class name.
     */
    public static function getClassName()
    {
        return self::class;
    }

    /**
     * Get the user profile photos from S3.
     *
     * @param bool $withDate
     * @return array|Collection
     */
    public static function getProfilePhotos(bool $withDate = false)
    {
        $photos = Storage::disk('s3')->files(
            'profile-photos/' . Auth::user()->id
        );

        if ($withDate) {
            $photos = collect($photos)->map(function ($photo) {
                return [
                    'path' => $photo,
                    'lastModified' => Storage::disk('s3')->lastModified($photo),
                ];
            });
        }

        return $photos;
    }

    /**
     * Filter url to convert it in S3 valid path.
     *
     * @param string $url
     * @return string
     */
    public static function filterPath(string $url)
    {
        return str_replace(env('AWS_PROFILE_URL'), '', $url);
    }
}
