<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalStoreRequest;
use App\Models\Action;
use App\Models\Journal;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
  public function store(JournalStoreRequest $req): JsonResponse
  {
    $validatedData = $req->validated();
    try {
      DB::beginTransaction();

      $journal = Journal::create([
        'reach_id' => $validatedData['reach_id'],
        'skill_id' => $validatedData['skill_id'],
        'description' => $validatedData['data']['description'],
      ]);

      $actionIds = [];
      foreach ($validatedData['data']['actionNames'] as $data) {
        $action = Action::where('skill_id', $validatedData['skill_id'])
          ->where('name', $data['select'])->first();
        if ($action) {
          $actionIds[] = $action->id;
        }
      }
      $journal->actions()->sync($actionIds);

      DB::commit();
      return Response()->json(['journal' => $journal, 'actionIds' => $actionIds], 201);
    } catch (Exception $e) {
      DB::rollBack();
      return Response()->json(['error' => 'JournalStore failed', 'message' => $e->getMessage()], 500);
    }
  }
}
