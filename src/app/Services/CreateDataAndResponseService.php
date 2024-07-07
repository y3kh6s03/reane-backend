<?php

namespace App\Services;

use App\Models\Action;
use App\Models\Reach;
use App\Models\Skill;
use Illuminate\Support\Facades\Log;

class CreateDataAndResponseService
{
  public static function createDataAndResponse($req)
  {
    Log::info('Request data:', $req->all());
    $reach = Reach::create([
      'name' => $req->input('reachName'),
      'user_email' => $req->input('userEmail'),
      'user_name' => $req->input('userName'),
      'user_image' => $req->input('userImage'),
    ]);

    $skills = $req->input('skills');
    $actionCount = 0;
    $skillDatas = [];

    foreach ($skills as $skillName => $skillData) {
      $skill = Skill::create([
        'name' => $skillName,
        'reach_id' => $reach->id,
      ]);

      $actions = $skillData['actions'];
      foreach ($actions as $actionData) {
        $actionCount++;
        $action = Action::create([
          'name' => $actionData['name'],
          'skill_id' => $skill->id,
          'reach_id' => $reach->id,
          'is_completed' => 0,
        ]);
        $skillDatas[$skillName][] = [
          'name' => $action->name,
          'is_completed' => $action->is_completed,
        ];
      }
    }

    $chartData = [
      'id' => $reach->id,
      'userName' => $reach->user_name,
      'userEmail' => $reach->user_email,
      'userImage' => $reach->user_image,
      'days' => DateCalcService::calcDate($reach->created_at),
      'reachName' => $reach->name,
      'skills' => $skillDatas,
      'actionCount' => $actionCount,
      'executedActionCount' => 0,
      'createdAt' => $reach->created_at,
    ];

    return $chartData;
  }
}
