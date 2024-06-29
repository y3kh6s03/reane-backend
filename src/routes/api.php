<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\Testcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::prefix('/myChart')
	->controller(ChartController::class)
	->name('reana')
	->group(function () {

		Route::post('/', 'index')->name('index');

		Route::post('/create', 'store')->name('store');

		Route::patch('/reach/{id}', 'reachPatch')->name('reachPatch');
		Route::delete('/reach/{id}', 'reachDelete')->name('reachDelete');

		Route::post('/reach/skill/{skillName}', 'skillEdit')->name('skillEdit');
		Route::patch('/reach/skill/{skillName}', 'skillPatch')->name('skillPatch');
		Route::delete('/reach/skill/{skillName}', 'skillDelete')->name('skillDelete');

		Route::post('/reach/skill/action/{actionid}', 'actionStore')->name('actionStore');
		Route::put('/reach/skill/action/{actionid}', 'actionPut')->name('actionPut');
		Route::patch('/reach/skill/action/{actionid}', 'actionPatch')->name('actionPatch');
		Route::delete('/reach/skill/action/{actionid}', 'actionDelete')->name('actionDelete');

		Route::get('/test', 'getTest')->name('get-test');
		Route::post('/test', 'postTest')->name('postt-test');
	});

Route::prefix('/journal')
	->controller(JournalController::class)
	->name('reana')
	->group(function () {
		Route::post('/', 'store')->name('store');
	});
