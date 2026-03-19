<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacketController;

Route::post('/packets', [PacketController::class, 'store']);