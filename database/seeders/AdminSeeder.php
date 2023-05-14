<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Admin User

        $user = User::create([
            'name' => 'Katawy',
            'email' => 'slidejam20@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('parker-lewis-cant-lose'),
            'bio' => 'Improve your skills with less effort in less time.',
            'profile_photo_path' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/profile-photos/1/LxOtC2VLCZ5Ml8mo3f684dE9wyGg2j0AUfAtUyBW.png',
        ]);

        Profile::create([
            'url' => url('/users/') . Str::slug($user->name),
            'slug' => Str::slug($user->name),
            'exp' => 350000,
            'honor' => 500000,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => 7,
            'last_activity' => now()->valueOf(),
        ]);

        $user->assignRole(Role::findByName('superadmin'));
    }
}
