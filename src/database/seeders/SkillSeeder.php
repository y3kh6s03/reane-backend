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
        $reach_hanahana = DB::table('reaches')->where('name', '体重49kg以下の達成')->first();

        $reach_ohtani = DB::table('reaches')->where('name', 'ドラフト１位８球団から指名される')->first();

        $reach_frontend = DB::table('reaches')->where('name', 'フロントエンドエンジニアを目指す')->first();

        $reach_backend = DB::table('reaches')->where('name', 'バックエンドエンジニアを目指す')->first();

        $reach_takken = DB::table('reaches')->where('name', '宅建を取得する')->first();

        $reach_kigyo = DB::table('reaches')->where('name', '起業する')->first();

        $skills = [
            ['name' => '食事管理', 'reach_id' => $reach_hanahana->id],
            ['name' => '運動', 'reach_id' => $reach_hanahana->id],
            ['name' => '睡眠', 'reach_id' => $reach_hanahana->id],
            ['name' => 'ストレス管理', 'reach_id' => $reach_hanahana->id],
            ['name' => '水分補給', 'reach_id' => $reach_hanahana->id],
            ['name' => '健康診断', 'reach_id' => $reach_hanahana->id],
            ['name' => '休息', 'reach_id' => $reach_hanahana->id],
            ['name' => 'メンタルケア', 'reach_id' => $reach_hanahana->id],
            // Ohtani's skills
            ['name' => 'キレ', 'reach_id' => $reach_ohtani->id],
            ['name' => 'スピード160km/h', 'reach_id' => $reach_ohtani->id],
            ['name' => '変化球', 'reach_id' => $reach_ohtani->id],
            ['name' => '運', 'reach_id' => $reach_ohtani->id],
            ['name' => '人間性', 'reach_id' => $reach_ohtani->id],
            ['name' => 'メンタル', 'reach_id' => $reach_ohtani->id],
            ['name' => '体づくり', 'reach_id' => $reach_ohtani->id],
            ['name' => 'コントロール', 'reach_id' => $reach_ohtani->id],
            // frontend
            ['name' => 'HTML/CSS', 'reach_id' => $reach_frontend->id],
            ['name' => 'JavaScript', 'reach_id' => $reach_frontend->id],
            ['name' => 'React.js', 'reach_id' => $reach_frontend->id],
            ['name' => 'TypeScript', 'reach_id' => $reach_frontend->id],
            ['name' => 'デザイン', 'reach_id' => $reach_frontend->id],
            ['name' => 'アクセシビリティ', 'reach_id' => $reach_frontend->id],
            ['name' => 'パフォーマンス最適化', 'reach_id' => $reach_frontend->id],
            ['name' => 'テスト', 'reach_id' => $reach_frontend->id],
            // backend
            ['name' => 'データベース管理', 'reach_id' => $reach_backend->id],
            ['name' => 'API開発', 'reach_id' => $reach_backend->id],
            ['name' => 'サーバー管理', 'reach_id' => $reach_backend->id],
            ['name' => 'セキュリティ', 'reach_id' => $reach_backend->id],
            ['name' => 'テストとデバッグ', 'reach_id' => $reach_backend->id],
            ['name' => 'パフォーマンス最適化', 'reach_id' => $reach_backend->id],
            ['name' => 'クラウドサービス', 'reach_id' => $reach_backend->id],
            ['name' => 'CI/CD', 'reach_id' => $reach_backend->id],
            //宅建
            ['name' => '法令上の制限', 'reach_id' => $reach_takken->id],
            ['name' => '宅地建物取引業法', 'reach_id' => $reach_takken->id],
            ['name' => '民法', 'reach_id' => $reach_takken->id],
            ['name' => '税法', 'reach_id' => $reach_takken->id],
            ['name' => '建築基準法', 'reach_id' => $reach_takken->id],
            ['name' => '土地・建物', 'reach_id' => $reach_takken->id],
            ['name' => '宅建業者の役割', 'reach_id' => $reach_takken->id],
            ['name' => '実務経験', 'reach_id' => $reach_takken->id],
            // 起業する

            ['name' => 'ビジネスアイデア', 'reach_id' => $reach_kigyo->id],
            ['name' => 'マーケットリサーチ', 'reach_id' => $reach_kigyo->id],
            ['name' => 'ビジネスプラン作成', 'reach_id' => $reach_kigyo->id],
            ['name' => '資金調達', 'reach_id' => $reach_kigyo->id],
            ['name' => '法律・規制', 'reach_id' => $reach_kigyo->id],
            ['name' => 'マーケティング', 'reach_id' => $reach_kigyo->id],
            ['name' => 'チームビルディング', 'reach_id' => $reach_kigyo->id],
            ['name' => '経営管理', 'reach_id' => $reach_kigyo->id],

        ];

        DB::table('skills')->insert($skills);
    }
}
