<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $reaches = [
            [
                'name' => '体重49kg以下の達成',
                'user_email' => 'sou19953131@gmail.com',
                'user_name' => '月 直人',
                'user_image' => 'https://images.pexels.com/photos/2381069/pexels-photo-2381069.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ドラフト１位８球団から指名される',
                'user_email' => 'shoheiohtani@example.com',
                'user_name' => '小谷 翔平',
                'user_image' => 'https://images.pexels.com/photos/1236701/pexels-photo-1236701.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'フロントエンドエンジニアを目指す',
                'user_email' => 'frontendengineer@example.com',
                'user_name' => 'ふろたん',
                'user_image' => 'https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'バックエンドエンジニアを目指す',
                'user_email' => 'backendengineer@example.com',
                'user_name' => '斑目 武',
                'user_image' => 'https://images.pexels.com/photos/1974596/pexels-photo-1974596.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '宅建を取得する',
                'user_email' => 'realestateagent@example.com',
                'user_name' => 'miyamae chihi',
                'user_image' => 'https://images.pexels.com/photos/1237119/pexels-photo-1237119.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '起業する',
                'user_email' => 'entrepreneur@example.com',
                'user_name' => '岩本 チー',
                'user_image' => 'https://images.pexels.com/photos/1231265/pexels-photo-1231265.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('reaches')->insert($reaches);
    }
}
