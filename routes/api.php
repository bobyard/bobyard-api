<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
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

Route::get('/collections', [CollectionController::class, 'Index']);
Route::get('/collections/new', [CollectionController::class, 'New']);
Route::get('/collections/{id}', [CollectionController::class, 'Show']);
Route::get('/nft/{id}', [CollectionController::class, 'Detail']);
Route::get('/profile/{wallet}',  [ProfileController::class, 'Index']);
Route::get('/profile/listed/{wallet}', [ProfileController::class, 'Listed']);
