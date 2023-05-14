<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        // reemplaza esto con tu propio código
        // el usuario se puede localizar con la fachada Auth
        $home = Auth::user()->hasRole(['superadmin', 'admin'])
            ? '/admin/dashboard'
            : '/user/dashboard';

        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect($home);
    }
}
