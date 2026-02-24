<?php

use App\Http\Controllers\SkillController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/skills', [SkillController::class, 'index']);
Route::get('/skills/{skill}', [SkillController::class, 'show']);
Route::post('/skills/{skill}/reservations', [ReservationController::class, 'store']);