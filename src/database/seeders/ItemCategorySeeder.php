<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 1. 腕時計 → 時計, メンズ, ファッション
            ['item_id' => 1, 'category_id' => 1],
            ['item_id' => 1, 'category_id' => 2],
            ['item_id' => 1, 'category_id' => 6],

            // 2. HDD → 家電
            ['item_id' => 2, 'category_id' => 3],

            // 3. 玉ねぎ3束 → 食品, 野菜
            ['item_id' => 3, 'category_id' => 4],
            ['item_id' => 3, 'category_id' => 5],

            // 4. 革靴 → ファッション, メンズ
            ['item_id' => 4, 'category_id' => 6],
            ['item_id' => 4, 'category_id' => 2],

            // 5. ノートPC → 家電, 文房具
            ['item_id' => 5, 'category_id' => 3],
            ['item_id' => 5, 'category_id' => 9],

            // 6. マイク → 家電, 生活雑貨
            ['item_id' => 6, 'category_id' => 3],
            ['item_id' => 6, 'category_id' => 7],

            // 7. ショルダーバッグ → ファッション, 生活雑貨
            ['item_id' => 7, 'category_id' => 6],
            ['item_id' => 7, 'category_id' => 7],

            // 8. タンブラー → 生活雑貨, カフェ
            ['item_id' => 8, 'category_id' => 7],
            ['item_id' => 8, 'category_id' => 8],

            // 9. コーヒーミル → 生活雑貨, カフェ
            ['item_id' => 9, 'category_id' => 7],
            ['item_id' => 9, 'category_id' => 8],

            // 10. メイクセット → コスメ
            ['item_id' => 10, 'category_id' => 10],
        ];

        DB::table('item_category')->insert($data);
    }
}
