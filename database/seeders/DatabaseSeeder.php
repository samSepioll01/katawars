<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // CREAR ROLES Y PERMISOS

        Rank::create(['name' => 'white', 'level_up' => 100]);
        Rank::create(['name' => 'yellow', 'level_up' => 200]);
        Rank::create(['name' => 'orange', 'level_up' => 300]);
        Rank::create(['name' => 'green', 'level_up' => 400]);
        Rank::create(['name' => 'blue', 'level_up' => 500]);
        Rank::create(['name' => 'brown', 'level_up' => 600]);
        Rank::create(['name' => 'black', 'level_up' => 700]);

        // CREAR ADMIN Y ASIGNAR ROLES

        User::factory(10)->create();

        // ASIGNAR ROLES A USUARIOS

        Category::create(['name' => 'algebra']);
        Category::create(['name' => 'algorithms']);
        Category::create(['name' => 'arrays']);
        Category::create(['name' => 'control flow']);
        Category::create(['name' => 'cryptography']);
        Category::create(['name' => 'data structures']);
        Category::create(['name' => 'dates']);
        Category::create(['name' => 'functional programming']);
        Category::create(['name' => 'geometry']);
        Category::create(['name' => 'higher order functions']);
        Category::create(['name' => 'language fundamentals']);
        Category::create(['name' => 'logic']);
        Category::create(['name' => 'loops']);
        Category::create(['name' => 'math']);
        Category::create(['name' => 'numbers']);
        Category::create(['name' => 'objects']);
        Category::create(['name' => 'physics']);
        Category::create(['name' => 'recursion']);
        Category::create(['name' => 'regex']);
        Category::create(['name' => 'sorting']);
        Category::create(['name' => 'strings']);
        Category::create(['name' => 'validation']);


    }
}
