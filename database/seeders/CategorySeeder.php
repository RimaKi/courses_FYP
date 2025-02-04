<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Mobile Development',
            'Ai',
            'Graphic Design',
            'English Language'
        ];
        foreach ($categories as $category){
            Category::create(['name'=>$category]);
        }
    }
}
