<?php

namespace App\Http\Controllers;

use App\Models\Reach;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChartController extends Controller
{
  public function getAllUsersChart(): JsonResponse
  {
    $allUsersCharts = Reach::with('skills.actions')->orderBy("created_at", "desc")->paginate();

    $response = $allUsersCharts->map(function ($reach) {
      $createdAt = new Carbon($reach->created_at);
      $updatedAt = new Carbon($reach->updated_at);
      $days = $createdAt->diffInDays($updatedAt);

      $skills = $reach->skills->mapWithKeys(function ($skill) {
        return [
          $skill->name => [
            'id' => $skill->id,
            'actions' => $skill->actions,
          ]
        ];
      });

      $actionCount = $reach->skills->sum(function ($skill) {
        return $skill->actions->count();
      });

      $executedActionCount = $reach->skills->sum(function ($skill) {
        return $skill->actions->where('is_completed', true)->count();
      });

      return [
        'id' => $reach->id,
        'userName' => $reach->user_name,
        'userImage' => $reach->user_image,
        'userEmail' => $reach->user_email,
        'reachName' => $reach->name,
        'skills' => $skills,
        'actionCount' => $actionCount,
        'executedActionCount' => $executedActionCount,
        'days' => $days,
        'createdAt' => $reach->created_at->toDateTimeString(),
        'updatedAt' => $reach->updated_at->toDateTimeString(),
      ];
    })->values()->all();

    return response()->json($response);
  }
}
