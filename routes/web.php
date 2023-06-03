<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\SubSystemController;

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
    Route::get('/prepKanban', [KanbanController::class, 'PreparetionKanban'])->name('prepKanban');
    Route::get('/', [KanbanController::class, 'ActiveKanban'])->name('home');
    Route::get('/FinishKanban', [KanbanController::class, 'FinishingKanban'])->name('FinishKanban');

    Route::get('/task/create', [TaskController::class, 'create'])->name('createTask');
    Route::post('/task/create', [TaskController::class, 'store']);
    Route::get('/task/edit/{task}', [TaskController::class, 'edit'])->name('editTask');
    Route::post('/task/edit/{task}', [TaskController::class, 'update']);

    Route::get('/system', [SystemController::class, 'index'])->name('systems');
    Route::get('/system/create', [SystemController::class, 'create'])->name('createSystem');
    Route::post('/system/create', [SystemController::class, 'store']);

    Route::get('/subsystem/create', [SubSystemController::class, 'create'])->name('createSubSystem');
    Route::post('/subsystem/create', [SubSystemController::class, 'store']);
});