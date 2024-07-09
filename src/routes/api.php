<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MyChartController;
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

Route::prefix('/chart')
	->controller(ChartController::class)
	->name('chart')
	->group(function () {
		Route::get('/all', 'getAllUsersChart')->name('getAllUsersChart');
	});

Route::prefix('/myChart')
	->controller(MyChartController::class)
	->name('myChart')
	->group(function () {

		Route::post('/', 'index')->name('index');

		Route::post('/create', 'store')->name('store');

		Route::patch('/reach/{id}', 'reachPatch')->name('reachPatch');
		Route::delete('/reach/{id}', 'reachDelete')->name('reachDelete');

		Route::post('/reach/skill/{skillId}', 'skillEdit')->name('skillEdit');
		Route::patch('/reach/skill/{skillId}', 'skillPatch')->name('skillPatch');
		Route::delete('/reach/skill/{skillId}', 'skillDelete')->name('skillDelete');

		Route::post('/reach/skill/action/{actionid}', 'actionStore')->name('actionStore');
		Route::put('/reach/skill/action/{actionid}', 'actionPut')->name('actionPut');
		Route::patch('/reach/skill/action/{actionid}', 'actionPatch')->name('actionPatch');
		Route::delete('/reach/skill/action/{actionid}', 'actionDelete')->name('actionDelete');

		Route::get('/test', 'getTest')->name('get-test');
		Route::post('/test', 'postTest')->name('postt-test');
	});

Route::prefix('/journal')
	->controller(JournalController::class)
	->name('journal')
	->group(function () {
		Route::post('/', 'index')->name('index');
		Route::post('/store', 'store')->name('store');
	});
