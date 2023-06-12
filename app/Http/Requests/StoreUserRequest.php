<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    use PasswordValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole(['superadmin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'role' => ['required', 'string'],
            'name' => ['unique:users', 'required', 'string', 'max:255'],
            'email' => ['unique:users', 'required', 'email', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'exp' => ['nullable', 'integer'],
            'honor' => ['nullable', 'integer'],
            'rank' => ['required', 'string'],
        ];
    }
}
