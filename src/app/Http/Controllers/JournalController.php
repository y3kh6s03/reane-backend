<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalIndexRequest;
use App\Http\Requests\JournalStoreRequest;
use App\Models\Action;
use App\Models\Journal;
use App\Models\Reach;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JournalController extends Controller
{

  public function index(JournalIndexRequest $req): JsonResponse
  {
    $validatedData = $req->validated();
    $userEmail = $validatedData['user_email'];

    $journals = Journal::where('user_email', $userEmail)
      ->with(['reach', 'skill', 'actions'])
      ->orderBy('created_at', 'desc')
      ->get()
      ->map(function ($journal) {
        return [
          'journal_id' => $journal->id,
          'reach_id' => $journal->reach_id,
          'reachName' => $journal->reach->name,
          'skill_id' => $journal->skill_id,
          'skillName' => $journal->skill->name,
          'actions' => $journal->actions->map(function ($action) {
            return [
              'id' => $action->id,
              'name' => $action->name
            ];
          })->toArray(),
          'description' => $journal->description,
          'date' => $journal->created_at
        ];
      });

    return response()->json($journals);
  }

  public function store(JournalStoreRequest $req): JsonResponse
  {
    $validatedData = $req->validated();
    try {
      DB::beginTransaction();

      $journal = Journal::create([
        'user_email' => $validatedData['user_email'],
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

      $journal->load('reach', 'skill', 'actions');
      $reach = Reach::find($validatedData['reach_id']);
      $resJournal = [
        'journal_id' => $journal->id,
        'reach_id' => $reach->id,
        'reachName' => $reach->name,
        'skill_id' => $journal->skill->id,
        'skillName' => $journal->skill->name,
        'actions' => $journal->actions->map(function ($action) {
          return [
            'id' => $action->id,
            'name' => $action->name,
          ];
        })->toArray(),
        'description' => $journal->description,
        'date' => $journal->created_at
      ];
      return response()->json($resJournal, 201);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['error' => 'JournalStore failed', 'message' => $e->getMessage()], 500);
    }
  }
}
