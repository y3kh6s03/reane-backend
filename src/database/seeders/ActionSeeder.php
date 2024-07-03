<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    public function run()
    {
        $reach = DB::table('reaches')->where('name', '体重49kg以下の達成')->first();
        $skills = DB::table('skills')->where('reach_id', $reach->id)->get();

        $actions = [
            // 食事管理に関連するアクション
            ['name' => 'カロリー制限食事計画', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],
            ['name' => '定期的な食事記録', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],
            ['name' => '野菜中心の食事', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],
            ['name' => '糖分摂取制限', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],
            ['name' => 'プロテイン摂取', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],
            ['name' => '食事バランスチェック', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],
            ['name' => '週一回の断食', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],
            ['name' => '水分補給の計画', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[0]->id],

            // 運動に関連するアクション
            ['name' => '毎朝のジョギング', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],
            ['name' => '週三回の筋トレ', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],
            ['name' => 'ヨガセッション', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],
            ['name' => 'ストレッチ', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],
            ['name' => 'サイクリング', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],
            ['name' => 'スイミング', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],
            ['name' => 'ウォーキング', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],
            ['name' => 'エアロビクス', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[1]->id],

            // 睡眠に関連するアクション
            ['name' => '早寝早起き', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],
            ['name' => '睡眠時間の記録', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],
            ['name' => '寝室の環境整備', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],
            ['name' => 'リラクゼーション', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],
            ['name' => 'カフェイン摂取の制限', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],
            ['name' => '昼寝の計画', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],
            ['name' => '夜の電子機器使用制限', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],
            ['name' => '睡眠アプリの使用', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[2]->id],

            // ストレス管理に関連するアクション
            ['name' => '瞑想', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            ['name' => '深呼吸法', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            ['name' => 'リラックス音楽の視聴', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            ['name' => '趣味の時間', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            ['name' => '自然散策', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            ['name' => 'ジャーナリング', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            ['name' => 'ストレス解消運動', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            ['name' => '笑いの時間', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[3]->id],
            // 水分補給に関連するアクション
            ['name' => '1日2リットルの水摂取', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],
            ['name' => '飲み物の記録', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],
            ['name' => '水分補給のリマインダー設定', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],
            ['name' => 'スポーツドリンクの摂取', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],
            ['name' => '水筒の持ち歩き', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],
            ['name' => 'カフェイン摂取制限', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],
            ['name' => 'アルコール摂取制限', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],
            ['name' => '水の味を楽しむ', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[4]->id],

            // 健康診断に関連するアクション
            ['name' => '定期健康診断の予約', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],
            ['name' => '健康診断結果の分析', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],
            ['name' => '血液検査', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],
            ['name' => '視力検査', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],
            ['name' => '聴力検査', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],
            ['name' => '内科検診', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],
            ['name' => '歯科検診', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],
            ['name' => '体力測定', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[5]->id],

            // 休息に関連するアクション
            ['name' => '定期的な休憩', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],
            ['name' => 'リラックス方法の実践', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],
            ['name' => '休日の計画', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],
            ['name' => '趣味の時間', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],
            ['name' => 'マッサージ', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],
            ['name' => '音楽鑑賞', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],
            ['name' => '映画鑑賞', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],
            ['name' => '温泉旅行', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[6]->id],

            // メンタルケアに関連するアクション
            ['name' => '自己反省', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
            ['name' => 'カウンセリング', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
            ['name' => 'メンタルヘルスのチェック', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
            ['name' => 'ポジティブ思考', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
            ['name' => 'リラクゼーション', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
            ['name' => '心の健康管理', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
            ['name' => '感情日記', 'is_completed' => true, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
            ['name' => 'ストレス緩和策', 'is_completed' => false, 'reach_id' => $reach->id, 'skill_id' => $skills[7]->id],
        ];

        DB::table('actions')->insert($actions);
    }
}
