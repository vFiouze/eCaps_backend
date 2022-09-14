<?php

use App\Http\Controllers\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUpload;
use App\Http\Controllers\SaveBlocks;
use App\Http\Controllers\DocumentController;

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

Route::post('/file-upload', [FileUpload::class, 'index']);
Route::post('/save-selected-blocks', [SaveBlocks::class, 'save']);
Route::post('/get-document', [DocumentController::class, 'index']);
Route::post('/get-blocks', [SaveBlocks::class, 'getSavedBlocks']);

