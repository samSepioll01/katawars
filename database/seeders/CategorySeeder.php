<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
