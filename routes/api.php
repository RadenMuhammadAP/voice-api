<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoiceController;


Route::any('voice', [VoiceController::class, 'store']);
