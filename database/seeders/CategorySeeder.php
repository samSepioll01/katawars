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
        Category::create([
            'name' => 'math',
            'bg_color' => 'bg-gradient-to-r from-emerald-500 to-emerald-900',
        ]);

        Category::create(['name' => 'algebra']);
        Category::create(['name' => 'numbers']);

        Category::create([
            'name' => 'arrays',
            'bg_color' => 'bg-gradient-to-tr from-rose-500 to-rose-600',
        ]);

        Category::create([
            'name' => 'dates',
            'bg_color' => 'bg-gradient-to-r from-slate-900 to-slate-700',
        ]);

        Category::create([
            'name' => 'strings',
            'bg_color' => 'bg-gradient-to-r from-blue-800 to-indigo-900',
        ]);

        Category::create([
            'name' => 'objects',
            'bg_color' => 'bg-gradient-to-r from-purple-500 to-purple-900',
        ]);

        Category::create(['name' => 'algorithms']);
        Category::create(['name' => 'loops']);
        Category::create(['name' => 'recursion']);
    }
}
