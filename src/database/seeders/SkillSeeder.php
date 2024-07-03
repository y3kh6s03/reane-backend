<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $reach = DB::table('reaches')->where('name', '体重49kg以下の達成')->first();

        $skills = [
            ['name' => '食事管理', 'reach_id' => $reach->id],
            ['name' => '運動', 'reach_id' => $reach->id],
            ['name' => '睡眠', 'reach_id' => $reach->id],
            ['name' => 'ストレス管理', 'reach_id' => $reach->id],
            ['name' => '水分補給', 'reach_id' => $reach->id],
            ['name' => '健康診断', 'reach_id' => $reach->id],
            ['name' => '休息', 'reach_id' => $reach->id],
            ['name' => 'メンタルケア', 'reach_id' => $reach->id],
        ];

        DB::table('skills')->insert($skills);
    }
}
