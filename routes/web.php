<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('user')->group(function () {
        Route::get('/', function () {
            return view('pages.manage.user.index');
        });
        Route::get('getUsers', [UserController::class, 'getUsers']);
        Route::get('getOneUser/{id}', [UserController::class, 'getOneUser']);
        Route::post('create', [UserController::class, 'create']);
        Route::post('update/{id}', [UserController::class, 'update']);
        Route::get('delete/{id}', [UserController::class, 'delete']);
        Route::post('resetPassword/{id}', [UserController::class, 'resetPassword']);
    });


    Route::prefix('category')->group(function () {
        Route::get('/', function () {
            return view('pages.manage.category.index');
        });
        Route::get('getCategories', [CategoryController::class, 'getCategories']);
        Route::get('getCategory/{id}', [CategoryController::class, 'getCategory']);
        Route::get('getDropdownCategory/{id}', [CategoryController::class, 'getDropdownCategory']);
        Route::post('create', [CategoryController::class, 'create']);
        Route::post('update/{id}', [CategoryController::class, 'update']);
        Route::get('delete/{id}', [CategoryController::class, 'delete']);
    });

    Route::prefix('income')->group(function () {
        Route::get('/', function () {
            return view('pages.income.index');
        });
        Route::get('getHistories', [HistoryController::class, 'getHistories']);
        Route::get('getHistory', [HistoryController::class, 'getHistory']);
        Route::get('getHistoryById/{id}', [HistoryController::class, 'getHistoryById']);
        Route::post('create', [HistoryController::class, 'create']);
        Route::post('update/{id}', [HistoryController::class, 'update']);
        Route::get('delete/{id}', [HistoryController::class, 'delete']);
        Route::get('export', [HistoryController::class, 'export']);
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', function () {
            return view('pages.dashboard.index');
        });

        Route::get('getAllDashboard', [DashBoardController::class, 'getAllDashboard']);
    });

});
