<?php

namespace Database\Seeders;

use App\Models\Kata;
use App\Models\Profile;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $katas = Kata::all();

        // VIP Users


        // 2 - Elliot Alderson

        $user = User::create([
            'name' => 'Elliot Alderson',
            'email' => 'f_society@protonmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'The democracy has been Hacked! F*** Socierty.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/2/8VyKIcV7m9mSi5vQl1latQOvS4LT5LkavxnoL2ah.jpg',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 1000,
            'honor' => 50000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));

        // 3 - Darlene Alderson

        $user = User::create([
            'name' => 'Dolores Haze',
            'email' => 'dolores_haze@protonmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => ':(){ :|:& };:',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/3/3zaWLBr9OnQIRH9Vz9eXCeL37D9g4g6VTN1ijWpw.png',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 800,
            'honor' => 70000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));


        // 4 - Dennis Ritchie

        $user = User::create([
            'name' => 'Dennis Ritchie',
            'email' => 'dennis_ritchie@belllabs.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'UNIX is very simple, it just takes a genius to understand its simplicity.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/4/YKLpgo95F4PJqEJyqYt8fbyA3X8PVSyN8KX4XXie.png',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 15000,
            'honor' => 150000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));
        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));

        // 5 - Linux Torvalds

        $user = User::create([
            'name' => 'Linus Torvalds',
            'email' => 'linus_torvalds@linuxsoftwarefundation.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Software is like sex, it’s better when it’s free.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/5/Zm6P3g8bQ84iGzY0nts5k1LaS05oe5A9M0esVQw4.png',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 7000,
            'honor' => 100000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));
        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));

        // 6 - Tim Berners-Lee

        $user = User::create([
            'name' => 'Tim Berners-Lee',
            'email' => 'tim_berners_lee@w3.org',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'I just had to take the idea of hypertext and connect it with the ideas of TCP and DNS and —voila!— the World Wide Web.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/6/rbJhyKBjonTDdA484QBkiZwSStLXD3vucezc1uG1.jpg',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 7000,
            'honor' => 90000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));
        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));

        // 7 - Steve Wozniak

        $user = User::create([
            'name' => 'Steve Wozniack',
            'email' => 'woz@apple.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Never trust a computer you can’t throw out the window.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/7/eMBfVBqel8EQMrZtdkZtJZLHS918fk2uvYJzj3Dt.jpg',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 6000,
            'honor' => 50000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));
        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));


        // 8 - Richard Stallman

        $user = User::create([
            'name' => 'Richard Stallman',
            'email' => 'richard_stallman@freesofwarefoundation.org',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Freedom is not being able to choose between a few imposed options, but having control of your own life. Freedom is not choosing who will be your master, it is not having a master.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/8/aWOQxqlDupue901ka92O193UMQjhGfsU8ZEYASEe.png',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 6000,
            'honor' => 50000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));
        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));

        // 9 - Steve Jobs

        $user = User::create([
            'name' => 'Steve Jobs',
            'email' => 'steve_jobs@apple.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'The only way to do great work is to love what you do. If you haven’t found it yet, keep looking. Don’t settle. Think Different!',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/9/r2zUPZzbuzrynz9XAhn3p8ElG525Ek4kZPNhLXha.jpg',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 5000,
            'honor' => 50000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));
        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));

        // 10 - Bill Gates

        $user = User::create([
            'name' => 'Bill Gates',
            'email' => 'bill_gates@microsoft.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Treat geeks well, someday you will work for one of them.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/10/XsH7ShJpa6bGFpY3KTv7FnV6WBmVNN93CEQhq3MG.png',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 6000,
            'honor' => 50000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));
        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));


        // Regular Users

        // 11

        $user = User::create([
            'name' => 'AKANeo',
            'email' => 'yavieneborrachocabron@hotmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 12

        $user = User::create([
            'name' => 'Mei Yagumi',
            'email' => 'mei@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 13

        $user = User::create([
            'name' => 'Jessica Harris',
            'email' => 'jess_harris@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 14

        $user = User::create([
            'name' => 'Garsi',
            'email' => 'garsi@outlook.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 15

        $user = User::create([
            'name' => 'ARkano',
            'email' => 'arkano@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 16

        $user = User::create([
            'name' => '4RNautilus',
            'email' => 'tandem@protonmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 17

        $user = User::create([
            'name' => 'Regular Joe',
            'email' => 'regular_joe@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 18 - Jeffrey Way

        $user = User::create([
            'name' => 'Jeffrey Way',
            'email' => 'jeffrey_way@laracasts.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Larabits for everyone!!',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/18/Nm2VZR45xkqI4TcSdYNCZuDlfT1r6N7oZ9FUNFqH.png',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 500,
            'honor' => 1000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 5,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));

        // 19 - Taylor Otwell

        $user = User::create([
            'name' => 'Taylor Otwell',
            'email' => 'taylor_otwell@laravel.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/19/FclLDiU5RpKIgvW04Y83bCfK1qX6pyOf8q42SGQN.jpg',
        ]);

        $profile = Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 500,
            'honor' => 1000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 5,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        $katas->each(fn($kata) => $profile->passedKatas()->attach($kata->id, [
            'code' => "public function solutionSeed()\n{\n\treturn 'Solution Seed!';\n}",
        ]));


        // 20

        $user = User::create([
            'name' => 'Uchiha Itachi',
            'email' => 'uchiha_itachi@konoha.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

        // 21

        $user = User::create([
            'name' => 'Puchikito',
            'email' => 'puchikito@spark.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'url' => url('/user') . '/' . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 1,
            'last_activity' => (int) now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('user'));

    }
}
