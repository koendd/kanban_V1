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

    // all routes for creating and editing kanban boards
    Route::controller(KanbanController::class)->middleware('can:manage_kanban_boards')->group(function() {
        Route::get('/kanbanboards', 'index')->name('kanbanboards');
        Route::get('/kanban/create', 'create')->name('createKanban');
        Route::post('/kanban/create', 'store');
        Route::get('/kanban/edit/{kanbanBoard}', 'edit')->name('editKanban');
        Route::post('/kanban/edit/{kanbanBoard}', 'update');
    });    

    Route::prefix('/kanban/{kanbanBoard}')->group(function() {
        // all routes for getting the content of a kanban board
        Route::controller(KanbanController::class)->group(function() {
            Route::get('/preparation', 'PreparetionKanban')->name('prepKanban');
            Route::get('/', 'ActiveKanban')->name('home');
            Route::get('/Finishing', 'FinishingKanban')->name('FinishKanban');
        });

        // all routes for showing, creating, editing a task or editing a task log
        Route::controller(TaskController::class)->group(function() {
            Route::get('/tasks', 'index')->name('tasks');
            Route::get('/task/create', 'create')->middleware('can:manage_tasks')->name('createTask');
            Route::post('/task/create', 'store')->middleware('can:manage_tasks');
            Route::get('/task/show/{task}', 'show')->name('showTask');
            Route::get('/task/edit/{task}', 'edit')->middleware('can:manage_tasks')->name('editTask');
            Route::post('/task/edit/{task}', 'update')->middleware('can:manage_tasks');
            Route::get('/task/transfer/{task}', 'transfer')->middleware('can:manage_tasks')->name('transferTask');
            Route::post('/task/transfer/{task}', 'move')->middleware('can:manage_tasks');
            Route::get('/log/edit/{taskLog}', 'editLog')->middleware('can:manage_task_logs')->name('editLog');
            Route::post('/log/edit/{taskLog}', 'updateLog')->middleware('can:manage_task_logs');
        });

        // all routes for creating and editing systems
        Route::controller(SystemController::class)->group(function() {
            Route::get('/systems', 'index')->name('systems');
            Route::get('/system/create', 'create')->middleware('can:manage_kanban_content')->name('createSystem');
            Route::post('/system/create', 'store')->middleware('can:manage_kanban_content');
        });

        // all routes for creating and editing sub-systems
        Route::controller(SubSystemController::class)->group(function() {
            Route::get('/subsystem/create', 'create')->middleware('can:manage_kanban_content')->name('createSubSystem');
            Route::post('/subsystem/create', 'store')->middleware('can:manage_kanban_content');
        });

        // all routes for creating and editing applicants
        Route::controller(ApplicantController::class)->group(function() {
            Route::get('applicants', 'index')->name('applicants');
            Route::get('/applicant/create', 'create')->middleware('can:manage_kanban_content')->name('createApplicant');
            Route::post('/applicant/create', 'store')->middleware('can:manage_kanban_content');
            Route::get('/applicant/edit/{applicant}', 'edit')->middleware('can:manage_kanban_content')->name('editApplicant');
            Route::post('/applicant/edit/{applicant}', 'update')->middleware('can:manage_kanban_content');
        });

        // all routes for creating and editing statuses
        Route::controller(StatusController::class)->group(function() {
            Route::get('statuses', 'index')->name('statuses');
            Route::get('/status/create', 'create')->middleware('can:manage_kanban_content')->name('createStatus');
            Route::post('/status/create', 'store')->middleware('can:manage_kanban_content');
            Route::get('/status/show/{status}', 'show')->name('showStatus');
            Route::get('/status/edit/{status}', 'edit')->middleware('can:manage_kanban_content')->name('editStatus');
            Route::post('/status/edit/{status}', 'update')->middleware('can:manage_kanban_content');
        });

        // all routes for creating and editing priorities
        Route::controller(PriorityController::class)->group(function() {
            Route::get('priorities', 'index')->name('priorities');
            Route::get('/priority/create', 'create')->middleware('can:manage_kanban_content')->name('createPriority');
            Route::post('/priority/create', 'store')->middleware('can:manage_kanban_content');
            Route::get('/priority/show/{priority}', 'show')->name('showPriority');
            Route::get('/priority/edit/{priority}', 'edit')->middleware('can:manage_kanban_content')->name('editPriority');
            Route::post('/priority/edit/{priority}', 'update')->middleware('can:manage_kanban_content');
        });

        Route::get('/statistics', [StatisticsController::class, 'getFullStatistics'])->name('statistics');
    });

    Route::get('/password/change', [ChangePasswordController::class, 'change'])->name('password_change');
    Route::post('/password/change', [ChangePasswordController::class, 'store']);
});