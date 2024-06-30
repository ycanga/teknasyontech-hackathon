<?php

use App\Http\Controllers\Api\PolicyController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
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

Route::post('/user/create-token', [UserController::class, 'createToken'])->name('user.create-token');

Route::get('/apps', [PolicyController::class, 'index'])->name('apps.index')->middleware('token.control');
Route::get('/apps/{appSlug}/policies/question={question}', [PolicyController::class, 'store'])->name('policies.store')->middleware('token.control');

