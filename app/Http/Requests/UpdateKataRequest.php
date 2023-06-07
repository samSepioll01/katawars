<?php

namespace App\Http\Requests;

use App\Models\Rank;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateKataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole(['admin', 'superadmin'])
            || Auth::user()->profile->rank_id === Rank::where('name', 'black')
                ->first()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'examples' => ['required', 'string'],
            'notes' => ['required', 'string'],
            'signature' => ['required', 'string', 'max:255'],
            'testclassname' => ['required', 'string', 'max:50'],
            'code' => ['required', 'string'],
            'solution' => ['required', 'string'],
            'mode' => ['required', 'integer'],
            'rank' => ['required', 'integer'],
            'videoname' => ['nullable', 'string', 'max:255'],
            'videocode' => ['nullable', 'string'],
        ];
    }
}
