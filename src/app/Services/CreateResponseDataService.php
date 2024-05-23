<?php

namespace App\Services;

use App\Models\Action;
use App\Models\Reach;
use App\Models\Skill;
use Illuminate\Support\Facades\Log;

class CreateResponseDataService
{
  public static function createResponseData($req)
  {
    $reach = Reach::create([
      'name' => $req->input('reachName'),
      'user_email' => $req->input('userEmail'),
      'user_name' => $req->input('userName'),
      'user_image' => $req->input('userImage'),
    ]);

    $skills = $req->input('skills');

    $actionCount = 0;
    foreach ($skills as $skillName => $val) {
      $skill = Skill::create([
        'name' => $skillName,
        'reach_id' => $reach->id,
      ]);
      $actions = $val;
      if (count($actions) >= 1) {
        foreach ($actions as $key => $actionData) {
          $actionCount++;
          $actionName = key($actionData);
          $action = Action::create([
            'name' => $actionName,
            'skill_id' => $skill->id,
            'reach_id' => $reach->id,
            'is_completed' => $actionData[$actionName]
          ]);
          $skillDatas[$skillName][] = array($action->name => $action->is_completed);
        }
      } else {
        $skillDatas = [];
      }
    }
    $chartData = [
      'id' => $reach->id,
      'userName' => $reach->user_name,
      'userEmail' => $reach->user_email,
      'userImage' => $reach->user_image,
      'days' => DateCalcService::calcDate($reach->createdAt),
      'reachName' => $reach->name,
      'skills' => $skillDatas,
      'actionCount' => $actionCount,
      'executedActionCount' => 0,
      'createdAt' => $reach->createdAt
    ];
    return $chartData;
  }
}
