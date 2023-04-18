<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\GitHubLoginPasswordMail;
use App\Models\Profile;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\InvalidStateException;

class GitHubLoginController extends Controller
{

    /**
     * @var Array $allowsURL
     * List urls allowed to interact with GitHub driver.
     */
    private $allowsURL;

    public function __construct()
    {
        $this->allowsURL = [
            'login' => env('APP_URL') . '/login/github',
            'sync' => env('APP_URL') . '/user/profile/sync/github',
        ];
    }

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
        $previousURL = request()->session()->get('_previous.url');

        // Manage the exception if the user Cancel the login with GitHub.
        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (InvalidStateException $e) {
            return redirect()->route('login');
        }

        $emailExists = User::where('email', $githubUser->getEmail())->exists();
        $userHasGitHub = User::where('github_id', $githubUser->getId())->first();
        $isSameUser = User::where('email', $githubUser->getEmail())
            ->first()?->id === $userHasGitHub?->id;

        if ($previousURL === $this->allowsURL['login']) {

            if ($emailExists && $userHasGitHub && $isSameUser) {
                $user = $this->updateGitHubLogin($githubUser);
            }

            if (!$emailExists && !$userHasGitHub) {
                $user = $this->createGitHubAccount($githubUser);
            }

            if ($emailExists && !$userHasGitHub) {
                return redirect()->route('login')
                    ->withErrors([
                        'message' => [
                            'The email has already been taken',
                            'To sync your GitHub account to your existing
                            Katawars account, log in with your Katawars
                            account and go to Dashboard > Settings >
                            Sync With GitHub Account.',
                        ]
                    ]);
            }

            Auth::login($user);

            return redirect()->route('dashboard');
        }

        if ($previousURL === $this->allowsURL['sync']) {
            dd($previousURL, $githubUser);
        }

    }

    // Auxiliar Functions

    /**
     * Update local Github data from token to create the login session.
     * @param \Laravel\Socialite\Two\User $githubUser
     * @return \App\Models\User $user
     */
    private function updateGitHubLogin($githubUser): User
    {
        $user = User::where('email', $githubUser->getEmail())->first();
        $user->github_token = $githubUser->token;
        $user->save();

        return $user;
    }

    /**
     * Create local account with GitHub account as external provider.
     * @param \Laravel\Socialite\Two\User $githubUser
     * @return \App\Models\User $user
     */
    private function createGitHubAccount($githubUser): User
    {
        $pass = $this->generateGitHubLoginPassword($githubUser);
        $name = $githubUser->getNickname();

        if (User::where('name', $name)->exists()) {
            $name = User::generateUniqueName(
                $githubUser->getNickname(),
                $githubUser,
            );
        }

        $user = User::create([
            'name' => $name,
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

        return $user;
    }

    /**
     *
     */
    private function syncGitHubAccount()
    {
        // Sincorniza la cuenta localmente cuando el usuario ha estado registrado previamente y hace clic en sincronizar.


    }

    /**
     * Generate a random password for a Github authenticated user.
     * @param Laravel\Socialite\Two\User $githubUser
     * @return string Random password for authenticated GitHub user.
     */
    private function generateGitHubLoginPassword($githubUser): string
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
