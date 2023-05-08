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
            'profile-photos/' . Auth::user()->profile->slug
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
}
