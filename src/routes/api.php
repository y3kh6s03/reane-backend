<?php

use App\Http\Controllers\ChartController;
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

		Route::post('/{reach}/{skillName}', 'skillEdit')->name('skillEdit');

		Route::delete('/{reach}', 'skillDelete')->name('skillDelete');

		Route::post('/{reach}/{skill}/{action}', 'actionStore')->name('actionStore');
		Route::put('/{reach}/{skill}/{action}', 'actionPut')->name('actionPut');
		Route::patch('/{reach}/{skill}/{action}', 'actionPatch')->name('actionPatch');
		Route::delete('/{reach}/{skill}/{action}', 'actionDelete')->name('actionDelete');

		Route::get('/test', 'getTest')->name('get-test');
		Route::post('/test', 'postTest')->name('postt-test');
	});
