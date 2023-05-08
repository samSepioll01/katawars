<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait AuxiliarFunctions
{
    /**
     * Get the user profile photos from S3.
     *
     * @param bool $withDate
     * @return array|Collection
     */
    public function getProfilePhotos(bool $withDate = false)
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
    public function filterS3Path(string $url)
    {
        return str_replace(env('AWS_PROFILE_URL'), '', $url);
    }
}
