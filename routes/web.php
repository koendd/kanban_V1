<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\SubSystemController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PriorityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'authenticateView'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('/', [HomeController::class, 'Welcome'])->name('welcome');

    Route::controller(KanbanController::class)->group(function() {
        Route::get('/kanbanboards', 'index')->name('kanbanboards');
        Route::get('/kanban/create', 'create')->name('createKanban');
        Route::post('/kanban/create', 'store');
        Route::get('/kanban/edit/{kanbanBoard}', 'edit')->name('editKanban');
        Route::post('/kanban/edit/{kanbanBoard}', 'update');
    });    

    Route::prefix('/kanban/{kanbanBoard}')->group(function() {
        Route::controller(KanbanController::class)->group(function() {
            Route::get('/preparation', 'PreparetionKanban')->name('prepKanban');
            Route::get('/', 'ActiveKanban')->name('home');
            Route::get('/Finishing', 'FinishingKanban')->name('FinishKanban');
        });

        Route::controller(TaskController::class)->group(function() {
            Route::get('/tasks', 'index')->name('tasks');
            Route::get('/task/create', 'create')->name('createTask');
            Route::post('/task/create', 'store');
            Route::get('/task/show/{task}', 'show')->name('showTask');
            Route::get('/task/edit/{task}', 'edit')->name('editTask');
            Route::post('/task/edit/{task}', 'update');
            Route::get('/task/transfer/{task}', 'transfer')->name('transferTask');
            Route::post('/task/transfer/{task}', 'move');
            Route::get('/log/edit/{taskLog}', 'editLog')->name('editLog');
            Route::post('/log/edit/{taskLog}', 'updateLog');
        });

        Route::controller(SystemController::class)->group(function() {
            Route::get('/systems', 'index')->name('systems');
            Route::get('/system/create', 'create')->name('createSystem');
            Route::post('/system/create', 'store');
        });

        Route::controller(SubSystemController::class)->group(function() {
            Route::get('/subsystem/create', 'create')->name('createSubSystem');
            Route::post('/subsystem/create', 'store');
        });

        Route::controller(ApplicantController::class)->group(function() {
            Route::get('applicants', 'index')->name('applicants');
            Route::get('/applicant/create', 'create')->name('createApplicant');
            Route::post('/applicant/create', 'store');
            Route::get('/applicant/edit/{applicant}', 'edit')->name('editApplicant');
            Route::post('/applicant/edit/{applicant}', 'update');
        });

        Route::controller(StatusController::class)->group(function() {
            Route::get('statuses', 'index')->name('statuses');
            Route::get('/status/create', 'create')->name('createStatus');
            Route::post('/status/create', 'store');
            Route::get('/status/show/{status}', 'show')->name('showStatus');
            Route::get('/status/edit/{status}', 'edit')->name('editStatus');
            Route::post('/status/edit/{status}', 'update');
        });

        Route::controller(PriorityController::class)->group(function() {
            Route::get('priorities', 'index')->name('priorities');
            Route::get('/priority/create', 'create')->name('createPriority');
            Route::post('/priority/create', 'store');
            Route::get('/priority/show/{priority}', 'show')->name('showPriority');
            Route::get('/priority/edit/{priority}', 'edit')->name('editPriority');
            Route::post('/priority/edit/{priority}', 'update');
        });

        Route::get('/statistics', [StatisticsController::class, 'getFullStatistics'])->name('statistics');
    });

    Route::get('/password/change', [ChangePasswordController::class, 'change'])->name('password_change');
    Route::post('/password/change', [ChangePasswordController::class, 'store']);
});