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
        $reach = [
            'name' => '体重49kg以下の達成',
            'user_email' => 'hanahana19953131@gmail.com',
            'user_name' => 'hanahana',
            'user_image' => 'https://images.pexels.com/photos/617278/pexels-photo-617278.jpeg',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('reaches')->insert($reach);
    }
}
