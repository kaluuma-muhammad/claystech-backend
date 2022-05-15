<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\DepartmentsController;
use App\Http\Controllers\API\EmployeesController;
use App\Http\Controllers\API\ProjectsController;
use App\Http\Controllers\API\ClientsController;
use App\Http\Controllers\API\ExpensesController;
use App\Http\Controllers\API\RevenuesController;
use App\Http\Controllers\API\RecordedRevenuesController;
use App\Http\Controllers\API\PaymentsController;
use App\Http\Controllers\API\UsersController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::resource('posts', PostsController::class);
    Route::resource('departments', DepartmentsController::class);
    Route::resource('employees', EmployeesController::class);
    Route::resource('projects', ProjectsController::class);
    Route::resource('clients', ClientsController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('revenues', RevenuesController::class);
    Route::resource('recorded-revenues', RecordedRevenuesController::class);
    Route::resource('payments', PaymentsController::class);
    Route::resource('users', UsersController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
