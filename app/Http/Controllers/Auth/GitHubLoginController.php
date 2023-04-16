<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\GitHubLoginPasswordMail;
use App\Models\Profile;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\InvalidStateException;

class GitHubLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     */
    public function handleProviderCallback()
    {

        //dd(request()->session()->get('_previous.url'));
        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (InvalidStateException $e) {
            return redirect()->route('login');
        }



        $nameExists = User::where('name', $githubUser->getNickname())->exists();
        $emailExists = User::where('email', $githubUser->getEmail())->exists();
        $user = User::where('github_id', $githubUser->getId())->first();

        // if ($emailExists) {
        //     return redirect()->route('login')
        //         ->withErrors([
        //             'message' => [
        //                 'The email has already been taken',
        //                 'Para sincronizar tu cuenta de GitHub a tu cuenta existente Inicia sesión con tu cuenta de Katawars y ve Dashboard > Settings > Sync With GitHub Account',
        //             ]
        //         ]);
        // }

        if (!$user) {

            $pass = $this->generateGitHubLoginPassword($githubUser);

            $user = User::create([
                'name' => $githubUser->getNickname(),
                'email' => $githubUser->getEmail(),
                'password' => Hash::make($pass),
                'bio' => $githubUser->user['bio'],
                'profile_photo_path' => $githubUser->getAvatar(),
                'github_id' => $githubUser->getId(),
                'github_repos_url' => $githubUser->user['repos_url'],
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
                'github_expires_in' => $githubUser->expiresIn,
                ]
            );

            $slug = Str::slug($user->name);

            Profile::create([
                'slug' => $slug,
                'url' => url("/users/$slug"),
                'exp' => 0,
                'honor' => 0,
                'is_darkmode' => true,
                'is_deleted' => false,
                'is_banned' => false,
                'rank_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->sendEmailVerificationNotification();
            Mail::send(new GitHubLoginPasswordMail($user->name, $user->email, $pass));
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function generateGitHubLoginPassword($githubUser)
    {
        return substr(
            Hash::make(
                $githubUser->getNickname()
                . $githubUser->getEmail()
                . $githubUser->getId()
                . now()
            ),
            7, 16,
        );
    }
}
