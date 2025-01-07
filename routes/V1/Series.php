<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\ChapterController;
use App\Http\Controllers\API\V1\SerieController;

Route::get('/series', [SerieController::class, 'index']);
Route::get('/series/{series}', [SerieController::class, 'show']);
Route::get('/series/search', [SerieController::class, 'search']);

Route::get('chapters/{chapter}', [ChapterController::class, 'show']);

