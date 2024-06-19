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
        'updatedAt' => $chartData->updated_at,
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

  public function reachPatch(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'id' => 'required|numeric',
      'editReachName' => 'required|string|max:255',
      'userEmail' => 'required|email|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors('バリデーションエラー')
      ], 422);
    }

    try {
      DB::beginTransaction();

      $reach = Reach::findOrFail($req->id);
      $reach->update(['name' => $req->editReachName]);

      DB::commit();

      return response()->json([
        'message' => 'Reach name updated successfully',
        'reach' => $reach
      ], 200);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function reachDelete(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'id' => 'required|numeric',
      'userEmail' => 'required|email|max:255',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors('idとuserEmailの値が正しくありません。')
      ], 422);
    }
    try {
      $actions = Action::where(['reach_id'=>$req->id])->delete();
      $skills = Skill::where(['reach_id'=>$req->id])->delete();
      $reach = Reach::where(['id'=>$req->id])->delete();
      return response()->json($actions);
    } catch (Exception $e) {
      return response()->json([
        'error'=>$e->getMessage()
      ]);
    }
    return response()->json('reach delete!!!!!');
  }

  public function skillEdit(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'id' => 'required|numeric',
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
        ->where('id', $req->id)
        ->firstOrFail();

      $skill = $reach->skills()->where('name', $req->currentSkillName)->firstOrFail();
      $skill->update(['name' => $req->editSkillName]);

      DB::commit();
      return response()->json($skill);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function skillPatch(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'id' => 'required|numeric',
      'userEmail' => 'required|email|max:255',
      'inputSkillName' => 'required|string|max:255',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors('文字列が多すぎます')
      ], 422);
    }

    try {
      DB::beginTransaction();
      $reach = Reach::where('user_email', $req->userEmail)
        ->where('id', $req->id)
        ->firstOrFail();
      $addedSkill = Skill::create([
        'reach_id' => $reach->id,
        'name' => $req->inputSkillName
      ]);
      DB::commit();
      return response()->json($addedSkill);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function skillDelete(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'id' => 'required|numeric',
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
        ->where('id', $req->id)
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

  public function actionStore(Request $req): JsonResponse
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
        $result = $action->update(['name' => $req->editActionName]);
        if ($result) {
          $updatedAction = $action->fresh();
        }
      } else {
        DB::rollBack();
        return response()->json([
          'error' => 'Action not found.'
        ], 404);
      }

      DB::commit();
      return response()->json($updatedAction);
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

  public function actionPut(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'reachName' => 'required|string|max:255',
      'userEmail' => 'required|email|max:255',
      'skillName' => 'required|string|max:255',
      'modalActions' => 'required|array',
      'modalActions.*.id' => 'nullable|integer',
      'modalActions.*.name' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    DB::beginTransaction();

    try {
      $updateActions = [];
      $reachId = Reach::where('name', $req->reachName)
        ->where('user_email', $req->userEmail)
        ->firstOrFail()->id;
      $skillId = Skill::where('name', $req->skillName)
        ->where('reach_id', $reachId)
        ->firstOrFail()->id;
      foreach ($req->modalActions as $data) {
        if (empty($data['id'])) {
          $createdAction = Action::create([
            'name' => $data['name'],
            'reach_id' => $reachId,
            'skill_id' => $skillId,
            'is_completed' => 0
          ]);
          $updateActions[] = [
            'id' => $createdAction->id,
            'name' => $createdAction->name,
            'isCompleted' => $createdAction->is_completed,
          ];
        } else {
          $existingData = Action::findOrFail($data['id']);
          if ($data['name'] !== $existingData->name) {
            $existingData->update(['name' => $data['name']]);
          }
          $existingData->fresh();
          $updateActions[] = [
            'id' => $existingData->id,
            'name' => $existingData->name,
            'isCompleted' => $existingData->is_completed,
          ];
        }
      }
      DB::commit();
      return response()->json($updateActions, 200);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => 'An error occurred while processing actions.'], 500);
    }
  }

  public function actionPatch(Request $req): JsonResponse
  {
    $validator = Validator::make($req->all(), [
      'actionId' => 'required|numeric',
      'isCompleted' => 'required|numeric|in:0,1',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors(), '$reqDataの中身' => $req], 422);
    }

    try {
      DB::beginTransaction();
      $action = Action::findOrFail($req->actionId);
      $newIsCompleted = $req->isCompleted === 1 ? 0 : 1;
      $action->update(['is_completed' => $newIsCompleted]);
      DB::commit();
      return response()->json($action, 200);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => 'An error occurred while processing actions.'], 500);
    }
    return response()->json('$req');
  }

  public function actionDelete(Request $req): JsonResponse
  {
    $actionId = $req->actionId;
    $action = Action::where('id', $actionId)->firstOrFail();
    $action->delete();
    return response()->json($action);
  }

  public function getTest()
  {
    return response()->json('getTest OK!!!!!!!');
  }

  public function postTest()
  {
    return response()->json('postTest OK!!!!!!!');
  }
}
