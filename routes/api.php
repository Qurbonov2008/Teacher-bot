<?php

use App\Http\Controllers\TelegramTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('telegram/webhook' , [TelegramTeacher::class , 'handle']);
