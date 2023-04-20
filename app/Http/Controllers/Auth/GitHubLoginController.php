<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\GitHubLoginPasswordMail;
use App\Models\Profile;
use App\Models\User;
use Laravel\Socialite\Two\User as GithubUser;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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

        } catch (ClientException $e) {
            return redirect()->route('profile.show')
                ->with([
                    'syncMessage' => 'Synchtonization Cancelled.',
                    'syncStatus' => 'error',
                ]);

        } catch (Exception $e) {
            return redirect('/');
        }

        if ($this->filterGitHubUser($githubUser)->fails()) {

            if ($previousURL === $this->allowsURL['login']) {
                return redirect()->route('login')
                ->withErrors([
                    'message' => [
                        'GitHub is not available in this momment.',
                        'Sorry, try later.'
                    ]
                ]);
            }

            if ($previousURL === $this->allowsURL['sync']) {
                return redirect()->route('profile.show')
                    ->with([
                        'syncMessage' => 'Oops! Something went wrong with GitHub. Sorry try later.',
                        'syncStatus' => 'error',
                    ]);
            }
        }

        // Case login or register with github account.
        if ($previousURL === $this->allowsURL['login']) {

            $emailExists = User::where('email', $githubUser->getEmail())->exists();
            $userHasGitHub = User::where('github_id', $githubUser->getId())->first();
            $isSameUser = User::where('email', $githubUser->getEmail())
                ->first()?->id === $userHasGitHub?->id;

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

        // Case synchronization
        if ($previousURL === $this->allowsURL['sync']) {

            [$message, $status] = ['', ''];

            if (auth()->user()->email === $githubUser->getEmail()) {

                $this->syncGitHubAccount($githubUser);

                $message = 'GitHub Account Synchronized Succesfully.';
                $status = 'success';

            } else {
                $status = 'error';
                $message = "Account Synchronization Failed.
                            External and local emails don't match.
                            You must update manually some of both
                            before they match and then try again.";
            }

            return redirect()->route('profile.show')
                ->with([
                    'syncStatus' => $status,
                    'syncMessage' => $message,
                ]);
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
            'github_url' => $githubUser->user['html_url'],
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
     * Synchronize data from Github account locally.
     * @param GithubUser $githubUser
     * @return void
     */
    private function syncGitHubAccount(GithubUser $githubUser): void
    {
        $name = $githubUser->getNickname();
        $user = User::find(auth()->user()->id);
        $profile = $user->profile;

        $userWithSameName = User::where('name', $name);

        if ($userWithSameName->exists()) {
            if ($user->id !== $userWithSameName->first()->id) {
                $name = auth()->user()->name;
            }
        }

        $user->name = $name;
        $user->bio = $githubUser['bio'] ?? $user->bio;
        $user->profile_photo_path = $githubUser->getAvatar();
        $user->github_id = $githubUser->getId();
        $user->github_repos_url = $githubUser['repos_url'];
        $user->github_token = $githubUser->token;
        $user->github_refresh_token = $githubUser->refreshToken;
        $user->github_expires_in = $githubUser->expiresIn;
        $user->save();

        $slug = Str::slug($user->name);

        $profile->slug = $slug;
        $profile->url = url("/users/$slug");
        $profile->save();
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

    /**
     * Filter and set the constraints for the fields that will be used.
     */
    private function filterGitHubUser($githubUser)
    {

        $githubUser2Validate = [
            'github_id' => $githubUser->getId(),
            'name' => $githubUser->getNickname(),
            'email' => $githubUser->getEmail(),
            'bio' => $githubUser->user['bio'],
            'avatar_url' => $githubUser->user['avatar_url'],
            'html_url' => $githubUser->user['html_url'],
            'repos_url' => $githubUser->user['repos_url'],
            'token' => $githubUser->token,
            'refreshToken' => $githubUser->refreshToken,
            'expiresIn' => $githubUser->expiresIn,
        ];

        return Validator::make($githubUser2Validate, [
            'github_id' => [
                'required',
                'integer',
                auth()->check()
                    ? Rule::unique('users')
                        ->ignore(auth()->user()->github_id, 'github_id')
                    : '',
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email'],
            'bio' => [ 'string', 'nullable', 'max:255'],
            'avatar_url' => ['string', 'nullable', 'max:2048', 'url'],
            'html_url' => ['string', 'required', 'max:2048', 'url'],
            'repos_url' => ['string', 'required', 'max:2048', 'url'],
            'token' => ['string', 'required', 'max:255'],
            'refreshToken' => ['string', 'nullable', 'max:255'],
            'expiresIn' => ['string', 'nullable', 'max:255'],
        ]);
    }
}
