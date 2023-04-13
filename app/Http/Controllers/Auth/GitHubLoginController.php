<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GitHubLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')
            ->scopes(['read:user', 'user:email', 'public_repo'])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        dd(
            $githubUser,
            $githubUser->getId(),
            $githubUser->getAvatar(),
            $githubUser->getName(),
            $githubUser->getNickname(),
            $githubUser->getEmail(),
            $githubUser->user,
            $githubUser->user['url'],
            $githubUser->user['gists_url'],
            $githubUser->user['repos_url'],
            $githubUser->user['bio'],
            $githubUser->approveScopes,
            $githubUser->token,
            $githubUser->refreshToken,
            $githubUser->expiresIn,
        );
    }
}
