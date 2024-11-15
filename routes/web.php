<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('setwebhook' , function()
{
   $request =  Telegram::setWebhook(['url' => 'https://2002-185-213-230-100.ngrok-free.app/api/telegram/webhook']);
});
