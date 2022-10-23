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
            'name' => 'Category1',
        ]);
        Category::create([
            'name' => 'Category2',
        ]);
        Category::create([
            'name' => 'Category3',
        ]);
        Category::create([
            'name' => 'Category4',
        ]);
        Category::create([
            'name' => 'Category5',
        ]);
//        Category::create([
//            'name' => 'subCategory1',
//            'parent_id' => '1',
//        ]);
//        Category::create([
//            'name' => 'subCategory2',
//            'parent_id' => '2',
//
//        ]);
//        Category::create([
//            'name' => 'subCategory3',
//            'parent_id' => '3',
//
//        ]);
//        Category::create([
//            'name' => 'subCategory4',
//            'parent_id' => '4',
//
//        ]);
//        Category::create([
//            'name' => 'subCategory5',
//            'parent_id' => '5',
//
//        ]);


    }
}
