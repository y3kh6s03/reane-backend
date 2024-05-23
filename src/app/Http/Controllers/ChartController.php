<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Reach;
use App\Models\Skill;
use App\Services\CreateResponseDataService;
use App\Services\DateCalcService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChartController extends Controller
{

  public function index(Request $req): JsonResponse
  {
    $email = $req->input('authEmail');
    $chartDatas = Reach::with(['skills.actions' => function ($query) {
      $query->select('id', 'skill_id', 'name', 'is_completed');
    }])->where('user_email', $email)->get();

    $resChartDatas = [];

    foreach ($chartDatas as $chartData) {
      $createdDate = explode(' ', explode('T', $chartData->created_at)[0])[0];
      $days = DateCalcService::calcDate($createdDate);

      $skills = [];
      $actionCount = 0;
      $executedActionCount = 0;

      foreach ($chartData->skills as $skill) {
        $actions = [];
        foreach ($skill->actions as $key => $action) {
          $actions[$key]=[
            'id'=>$action->id,
            'name'=>$action->name,
            'isCompleted'=>$action->is_completed,
          ];
          // $actions[$action->name] = $action->is_completed;

          $actionCount++;
          if ($action->is_completed === 1) {
            $executedActionCount++;
          }
        }
        $skills[$skill->name] = $actions;
      }

      $resChartDatas[] = [
        'id' => $chartData->id,
        'userName' => $chartData->user_name,
        'userImage' => $chartData->user_image,
        'userEmail' => $chartData->user_email,
        'reachName' => $chartData->name,
        'skills' => $skills,
        'actionCount' => $actionCount,
        'executedActionCount' => $executedActionCount,
        'days' => $days,
        'createdAt' => $chartData->created_at,
      ];
    }

    return response()->json($resChartDatas);
  }

  public function store(Request $req): JsonResponse
  {

    $validator = Validator::make($req->all(), [
      'reachName' => 'required|string|max:255',
      'userEmail' => 'required|email|max:255',
      'userName' => 'required|string|max:255',
      'userImage' => 'nullable|string|max:255',
      'skills' => 'required|array',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()
      ], 422);
    }

    try {
      DB::beginTransaction();

      $chartData = CreateResponseDataService::CreateResponseData($req);

      DB::commit();

      return response()->json($chartData);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()]);
    }
  }
}
