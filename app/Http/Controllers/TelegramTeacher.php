<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramTeacher extends Controller
{
    public function handle()
    {
    try {

        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();
        $callbackQuery = $update->getCallbackQuery();
        $chatId = $message?->chat?->id ?? $callbackQuery?->getMessage()->getChat()->getId();
        $messageText = $message?->text ?? "/start";


        if($messageText === '/start')
        {
            // Foydalanuvchi ro'yxatdan o'tmagan bo'lsa, telefon raqamini so'rash
            $welcomeText = "Assalomu alaykum! Iltimos, telefon raqamingizni yuboring.";
            $phoneButtonText = '📞 Telefon raqamni yuborish';

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $welcomeText,
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => $phoneButtonText, 'request_contact' => true]],
                    ],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ])
            ]);
        }


    } catch (\ErrorException $e) {
        return "Xatolik yuzberdi" . $e;
    }
    }
}
