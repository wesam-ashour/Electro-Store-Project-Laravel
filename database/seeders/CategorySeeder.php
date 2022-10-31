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
            'name' => 'Women’s Apparel',
        ]);
        Category::create([
            'name' => 'Gifts',
        ]);
        Category::create([
            'name' => 'Jewerlly & Accessories',
        ]);
        Category::create([
            'name' => 'Shoes',
        ]);
        Category::create([
            'name' => 'Handbags',
        ]);
        Category::create([
            'name' => 'Sale',
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
