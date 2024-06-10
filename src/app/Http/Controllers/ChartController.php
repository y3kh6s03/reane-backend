<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Reach;
use App\Models\Skill;
use App\Services\CreateDataAndResponseService;
use App\Services\DateCalcService;
use Exception;
use Illuminate\Database\QueryException;
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
          $actions[$key] = [
            'id' => $action->id,
            'name' => $action->name,
            'isCompleted' => $action->is_completed,
          ];
          // $actions[$action->name] = $action->is_completed;

          $actionCount++;
          if ($action->is_completed === 1) {
            $executedActionCount++;
          }
        }
        $skills[$skill->name] = [
          'id' => $skill->id,
          'actions' => $actions,
        ];
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

      $chartData = CreateDataAndResponseService::CreateDataAndResponse($req);

      DB::commit();

      return response()->json($chartData);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function skillEdit(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'userEmail' => 'required|email|max:255',
      'reachName' => 'required|string|max:255',
      'editSkillName' => 'required|string|max:255',
      'currentSkillName' => 'required|string|max:255',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors('文字列が多すぎます')
      ], 422);
    }

    try {
      DB::beginTransaction();

      $reach = Reach::where('user_email', $req->userEmail)
        ->where('name', $req->reachName)
        ->firstOrFail();

      $skill = $reach->skills()->where('name', $req->currentSkillName)->firstOrFail();
      $skill->update(['name' => $req->editSkillName]);

      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()], 500);
    }
    return response()->json($skill);
  }

  public function skillDelete(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'userEmail' => 'required|email|max:255',
      'reachName' => 'required|string|max:255',
      'skillName' => 'required|string|max:255',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()
      ], 422);
    }

    try {
      DB::beginTransaction();

      $reach = Reach::where('user_email', $req->userEmail)
        ->where('name', $req->reachName)
        ->firstOrFail();

      $skill = $reach->skills()->where('name', $req->skillName)->firstOrFail();
      $actions = Action::where('skill_id', $skill->id)->get();

      foreach ($actions as $action) {
        $action->delete();
      }

      $skill->delete();

      DB::commit();
      return response()->json(['message' => '削除成功'], 200);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function actionEdit(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'reachName' => 'required|string|max:255',
      'skillName' => 'required|string|max:255',
      'actionId' => 'required|numeric',
      'actionName' => 'required|string|max:255',
      'editActionName' => 'required|string|max:255',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()
      ], 422);
    }

    try {
      DB::beginTransaction();

      $action = Action::where('id', $req->actionId)->first();
      if ($action) {
        $action->update(['name' => $req->editActionName]);
      } else {
        DB::rollBack();
        return response()->json([
          'error' => 'Action not found.'
        ], 404);
      }

      DB::commit();
    } catch (QueryException $e) {
      DB::rollBack();
      return response()->json([
        'error' => 'Database query error occurred while updating the action.'
      ], 500);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'error' => 'An unexpected error occurred while updating the action.'
      ], 500);
    }

    return response()->json(null, 204);
  }

  public function actionDelete(Request $req): JsonResponse
  {
    $reqData = $req->all();
    return response()->json($reqData);
  }
}
