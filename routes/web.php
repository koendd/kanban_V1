<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\SubSystemController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\StatisticsController;

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

    Route::get('/kanbanboards', [KanbanController::class, 'index'])->name('kanbanboards');
    Route::get('/kanban/create', [KanbanController::class, 'create'])->name('createKanban');
    Route::post('/kanban/create', [KanbanController:: class, 'store']);
    Route::get('/kanban/edit/{kanbanBoard}', [KanbanController::class, 'edit'])->name('editKanban');
    Route::post('/kanban/edit/{kanbanBoard}', [KanbanController:: class, 'update']);
    
    Route::get('/kanban/{kanbanBoard}/preparation', [KanbanController::class, 'PreparetionKanban'])->name('prepKanban');
    Route::get('/kanban/{kanbanBoard}', [KanbanController::class, 'ActiveKanban'])->name('home');
    Route::get('/kanban/{kanbanBoard}/Finishing', [KanbanController::class, 'FinishingKanban'])->name('FinishKanban');

    Route::get('/kanban/{kanbanBoard}/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/kanban/{kanbanBoard}/task/create', [TaskController::class, 'create'])->name('createTask');
    Route::post('/kanban/{kanbanBoard}/task/create', [TaskController::class, 'store']);
    Route::get('/kanban/{kanbanBoard}/task/show/{task}', [TaskController::class, 'show'])->name('showTask');
    Route::get('/kanban/{kanbanBoard}/task/edit/{task}', [TaskController::class, 'edit'])->name('editTask');
    Route::post('/kanban/{kanbanBoard}/task/edit/{task}', [TaskController::class, 'update']);
    Route::get('/kanban/{kanbanBoard}/log/edit/{taskLog}', [TaskController::class, 'editLog'])->name('editLog');
    Route::post('/kanban/{kanbanBoard}/log/edit/{taskLog}', [TaskController::class, 'updateLog']);

    Route::get('/kanban/{kanbanBoard}/systems', [SystemController::class, 'index'])->name('systems');
    Route::get('/kanban/{kanbanBoard}/system/create', [SystemController::class, 'create'])->name('createSystem');
    Route::post('/kanban/{kanbanBoard}/system/create', [SystemController::class, 'store']);

    Route::get('/kanban/{kanbanBoard}/subsystem/create', [SubSystemController::class, 'create'])->name('createSubSystem');
    Route::post('/kanban/{kanbanBoard}/subsystem/create', [SubSystemController::class, 'store']);

    Route::get('/kanban/{kanbanBoard}/applicants', [ApplicantController::class, 'index'])->name('applicants');
    Route::get('/kanban/{kanbanBoard}/applicant/create', [ApplicantController::class, 'create'])->name('createApplicant');
    Route::post('/kanban/{kanbanBoard}/applicant/create', [ApplicantController::class, 'store']);
    Route::get('/kanban/{kanbanBoard}/applicant/edit/{applicant}', [ApplicantController::class, 'edit'])->name('editApplicant');
    Route::post('/kanban/{kanbanBoard}/applicant/edit/{applicant}', [ApplicantController::class, 'update']);

    Route::get('/kanban/{kanbanBoard}/statistics', [StatisticsController::class, 'getFullStatistics'])->name('statistics');
});