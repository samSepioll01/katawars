<?php

namespace App\CustomClasses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class S3 extends Facade
{

    private const S3basePath = 'https://s3.eu-south-2.amazonaws.com/katawars.es';

    /**
     * Override method to declare the S3 Facade.
     */
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
     * Return the base url from your app S3 bucket.
     * If bucket base url dont registered in
     * AWS_PROFILE property of .env file
     * or existant values dont matches,
     * null is returned.
     */
    public static function getBaseUrl(): string|null
    {
        return self::S3basePath === env('AWS_PROFILE_URL')
            ? self::S3basePath
            : null;
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
        return filter_var($url, FILTER_VALIDATE_URL)
            ? str_replace(self::getBaseUrl(), '', $url)
            : $url;
    }

    /**
     * Generate the path for the resources to store in S3.
     *
     * @param string $language
     * @return string
     */
    public static function generateUploadPath(string $language): string
    {
        return '/katas/' . strtolower($language) . '/' . Str::random(40) . '.txt';
    }
}
