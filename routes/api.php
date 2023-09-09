<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\SystemController;
use App\Http\Controllers\Api\StatisticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/task/updateStatus', [TaskController::class, 'updateStatus'])->middleware('auth:api')->name('updateTaskStatusApi');
Route::get('/task/{id}', [TaskController::class, 'getTask'])->middleware('auth:api')->name('getTaskApi');
Route::post('/task/addLogEntry', [TaskController::class, 'addLogEntryToTask'])->middleware('auth:api')->name('addTaskLogEntryApi');

Route::get('/system/{system}/subsystems', [SystemController::class, 'getSubsytems'])->middleware('auth:api')->name('getSubsystemsApi');

Route::get('/statistics/{kanbanBoard}/data', [StatisticsController::class, 'getStatisticsData'])->name('getStatisticsDataApi');