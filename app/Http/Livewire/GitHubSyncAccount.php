<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class GitHubSyncAccount extends Component
{

    public $confirmingSync = false;

    public $password = '';

    public function confirmSync()
    {
        $this->password = '';
        $this->dispatchBrowserEvent('confirming-github-sync-account');
        $this->confirmingSync = true;
    }

    public function syncWithGitHub()
    {
        $this->resetErrorBag();

        if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        request()->session()->put([
            'password_hash_'.Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        ]);

        $this->confirmingSync = false;

        return redirect()->route('github.sync');
    }

    public function render()
    {
        return view('livewire.git-hub-sync-account');
    }
}
