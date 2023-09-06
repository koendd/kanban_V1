<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\SubSystemController;
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
    
    Route::get('/kanban/{kanbanBoard}/preparation', [KanbanController::class, 'PreparetionKanban'])->name('prepKanban');
    Route::get('/kanban/{kanbanBoard}', [KanbanController::class, 'ActiveKanban'])->name('home');
    Route::get('/kanban/{kanbanBoard}/Finishing', [KanbanController::class, 'FinishingKanban'])->name('FinishKanban');

    Route::get('/kanban/{kanbanBoard}/task/create', [TaskController::class, 'create'])->name('createTask');
    Route::post('/kanban/{kanbanBoard}/task/create', [TaskController::class, 'store']);
    Route::get('/kanban/{kanbanBoard}/task/edit/{task}', [TaskController::class, 'edit'])->name('editTask');
    Route::post('/kanban/{kanbanBoard}/task/edit/{task}', [TaskController::class, 'update']);

    Route::get('/kanban/{kanbanBoard}/systems', [SystemController::class, 'index'])->name('systems');
    Route::get('/kanban/{kanbanBoard}/system/create', [SystemController::class, 'create'])->name('createSystem');
    Route::post('/kanban/{kanbanBoard}/system/create', [SystemController::class, 'store']);

    Route::get('/kanban/{kanbanBoard}/subsystem/create', [SubSystemController::class, 'create'])->name('createSubSystem');
    Route::post('/kanban/{kanbanBoard}/subsystem/create', [SubSystemController::class, 'store']);

    Route::get('/kanban/{kanbanBoard}/statistics', [StatisticsController::class, 'getFullStatistics'])->name('statistics');
});