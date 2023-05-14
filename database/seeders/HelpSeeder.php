<?php

namespace Database\Seeders;

use App\Models\Help;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class HelpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Generate list of availables languages.
         * @param Collection $languages
         * @return string
         */
        $generateLanguagesHTML = function (Collection $languages): string
        {
            $returnHTML = '';

            foreach ($languages as $language) {

                $returnHTML .= <<<EOT
                    <li class="flex flex-row items-center">
                        <div class="w-full h-16 flex flex-row items-center">
                            <div class="px-5"><img src="$language->uri_logo" class="w-8 h-8" /></div>
                            <div class="px-5">$language->name</div>
                        </div>
                    </li>
                EOT;
            }
            return $returnHTML;
        };

        Help::create([
            'title' => 'What are Katas?',
            'description' => 'Katas are programming challenges that can be available in several programming languages and whose objective is to make the user obtain reasoning, memorization of features in the languages used and understanding of the patterns they follow, repeatedly the challenges, to learn practical and quickly programming. The term has its origin in martial arts and works in such a way that people memorize and train small repetitive movements and then apply it in other contexts.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'What is EXP and how is it calculated?',
            'description' => "EXP is a shorhand for EXPerience points. It's meant to give users a genuine sense of progress and accomplishment. The amount of EXP awarded is based on Katas mode or Kataway accomplished.",
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'What is HONOR and how is obtained?',
            'description' => 'Honor is points of popularity and prestige for users. It is necessary to perform some actions such as Kumites. HONOR points are obtained by making contributions to the platform such as publishing resources or Katas, winning Kumites or getting likes on your resources or solutions provided to katas, as well as saving challenges developed by you in their favorites list.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'Which are the Katas modes?',
            'description' => <<<EOL
                <ul>There are three differents modes:
                    <li>Training: Basic learning mode.
                        <ul>
                            <li>The user can see the statement beforehand and try to solve it without limit of attempts.</li>
                            <li>You can also consult resources shared by other users as clues to learn what to use to solve the kata (this has no penalty).</li>
                            <li>Once overcome you will be able to visualize the solutions of other users.</li>
                        </ul>
                    </li>
                    <li>Blitz: Fast time trial mode.
                        <ul>
                            <li>The user will not be able to see the statement of the Kata until they press the Start button, nor will they have resources to help from other users.</li>
                            <li>Once a timer is activated and will control the time in which the user overcomes the challenge, that time will establish the ranking of classification for that Kata.</li>
                            <li>It has a higher EXP score than Training mode and if the user sets a new time record beating the best mark they will earn HONOR points.</li>
                            <li>If the user abandons the challenge, closes the window or leaves the resolution screen once the challenge has been activated, it will be considered as not overcome and will enter the category of skipped challenges.</li>
                        </ul>
                    </li>
                    <li>Kumites: Competitive mode against another user.
                        <ul>
                            <li>The participants will not have resources to help or see the statement beforehand. </li>
                            <li>The first one to validate a solution for the proposed Kata will win the confrontation.</li>
                            <li>The winner will get EXP and HONOR points from the other user.</li>
                            <li>To participate each user will have to have a minimum number of HONOR.</li>
                            <li>Users will be matched regardless of their level, but the challenge chosen for the confrontation will be established by the challenges available for the user who has the lowest level.</li>
                            <li>NO negative HONOR is allowed.</li>
                            <li>If one of the users leaves the game or exits the application, ONLY if the other user obtains a solution will be determined as winner to the opponent.</li>
                            <li>In case of not having obtained solution by some of the participants in an established time, the Kumite will be considered as null.</li>
                        </ul>
                    </li>
                </ul>
            EOL,
            'section' => 'general',
        ]);


        Help::create([
            'title' => 'How does the ranking levels system work?',
            'description' => 'The level ranking system is based on the belts of martial arts and establishes a filter of the Katas that the user has available to overcome at each level. The user will be able to overcome those Katas that have a rank equal to or lower than their current rank.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'How can I level up?',
            'description' => 'To level up the user must earn EXP points by overcoming Training Katas, Blitz Kumites or overcoming Kataways.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'What are Kataways?',
            'description' => 'Kataways are a set of Katas that are grouped by categories or some differential characteristic and that to be overcome they have to be overcome all the Katas that compose them. The included Katas can be of various levels. They grant EXP points.',
            'section' => 'general',
        ]);

        $returnHTML = $generateLanguagesHTML(Language::all(), true);

        Help::create([
            'title' => 'What languages are available actually?',
            'description' => <<<EOL
                <ul>The actually available languages are:
                    $returnHTML
                </ul>
            EOL,
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'What are Favorites Katas?',
            'description' => 'Your Favorites Katas List are the Katas that you liked the most their approach. To be able to include them in your list you must have overcome them previously. The action of adding it will grant the creator of the Kata points of HONOR.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'What are Saved Katas?',
            'description' => 'Your list of saved katas are the katas that you have not yet overcome and have saved to overcome them later.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => "What can I do if I can't overcome a Kata?",
            'description' => 'Keep calm. Katawars is for learning and one of the best ways is to see the code of others. When you can’t overcome a Kata, on the main page of the Kata go to the Solutions tab. There you will be shown the blocked content and you will be able to see a button in the center of the section called See Solutions. This button serves to unlock the solutions in exchange for HONOR points. From that moment on, you will be able to see the solutions of other users, but you will not be able to overcome the Kata or, therefore, add any score.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'How can I create a Kata?',
            'description' => 'The section of creating katas is unlocked when the user has reached the Black Belt. Once at that level, the corresponding link will be unlocked in the sidebar and you will be able to access that section. In it you will have to create a test in the corresponding language that will be the validator of the challenge and provide in another block a valid solution for that challenge. You will also have to set the title and statement of it, as well as a slug to define the signature that is shown to the user. Then you will send the Kata and the administrators will have to validate that solution and according to the level they set, it will determine the amount of HONOR points you receive.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => "What happend when a user pass a kata that I've created?",
            'description' => 'You will be added HONOR points every time a user beats a Kata you have created.',
            'section' => 'general',
        ]);

        Help::create([
            'title' => 'How do I change my profile photo?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Profile Information Section > Select a new photo > Select a photo in you device > Save.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How do I change my username?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Profile Information Section > Name > Type your new username > Save.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How do I change my email?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Profile Information Section > Email > Type your new email > Save.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How do I change my bio?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Profile Information Section > Bio > Type your new bio > Save.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How do I change my password?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Update Password Section > Fill Current Password, New Password & Confirm Password  > Save.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How do I activate the Two Factor Authentication?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Two Factor Authentication Section > Enable > Insert your password > Scan QR Code in your Microsoft, Google or Latch Authenticator > Insert the code > Confirm.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How do I log out other sessions browser?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Browser Sessions Section > Log Out Other Browser Sessions.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How synchronize my GitHub account locally?',
            'description' => 'Click Avatar > Settings > Scroll to Sync with GitHub Account Section > Sync With GitHub. You must check that both your GitHub and local email are matching.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How do I delete my account?',
            'description' => 'You must click on the navbar Avatar > Settings > Scroll to Delete Account Section (At bottom) > Delete Account.',
            'section' => 'profile',
        ]);

        Help::create([
            'title' => 'How does the account deletion system work?',
            'description' => 'When the user deletes an account, the profile associated with the account is blocked. From that moment on, the user’s associated data such as photos, username and other activity will no longer be visible to other members of the community. The user will no longer be able to access their account from the login. The platform will store the data for the appropriate legal time for its request by the competent authorities.',
            'section' => 'profile',
        ]);
    }
}
