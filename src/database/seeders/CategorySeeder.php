<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => '時計'],     // id:1
            ['name' => 'メンズ'],   // id:2
            ['name' => '家電'],     // id:3
            ['name' => '食品'],     // id:4
            ['name' => '野菜'],     // id:5
            ['name' => 'ファッション'], // id:6
            ['name' => '生活雑貨'], // id:7
            ['name' => 'カフェ'],   // id:8
            ['name' => '文房具'],   // id:9
            ['name' => 'コスメ'],   // id:10
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
