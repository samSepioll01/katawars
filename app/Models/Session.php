<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Session extends Model
{
    use HasFactory;

    /**
     * Accesor method thats trigger where last_activity field change.
     * Update the Profile's last_activity field to hold alive the record.
     * Because when the session expires or logout, the garbage collector
     * delete the register motivated user_id field will be null.
     */
    public function getLastActivityAttribute()
    {
        $last = DB::table('sessions')
                    ->select('last_activity')
                    ->where('user_id', Auth::user()->id)
                    ->first()
                    ->last_activity;

        $user = Auth::user();

        if ($user->email_verified_at) {
            $profile = $user->profile;
            $profile->last_activity = $last;
            $profile->save();
        }
    }
}
