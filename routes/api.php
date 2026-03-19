<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacketController;


Route::get('/packets', [PacketController::class, 'index']);
Route::post('/packets', [PacketController::class, 'store']);
Route::get('/packets/{id}', [PacketController::class, 'show']);
Route::put('/packets/{id}/status', [PacketController::class, 'updateStatus']);
