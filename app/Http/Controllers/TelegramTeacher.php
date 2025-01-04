<?php

namespace App\Http\Controllers;

use App\Models\Register;
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
        $contact = $message?->contact;
        $location = $message?->location;
        $firstName = $message?->from?->first_name ?? "Foydalanuvchini ismi yo'q";
        $lastName = $message?->from?->last_name ?? "Foydalanuvchini familyasi yo'q";
        $username = $message?->from?->username ?? "Foydalanuvchini username yo'q";



        if($contact)
        {

            $phoneNumber = $contact->phone_number;

            Register::create([
                'phone_number' => $phoneNumber,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'chat_id' => $chatId,
            ]);

            Telegram::sendMessage([
             'chat_id' => $chatId,
            'text' => 'Siz muvaffaqiyatli ro'yxatdan o'tdingiz',
             'reply_markup' => json_encode(
                 'keyboard' => [
                 [['text' => '📋 Kurs tanlash'] , ['text' => '💬 O'qituvchilik qilish']],
                 ]
             )
            
            ])
        }

        if($messageText === '/start')
        {




            $user = Register::where('chat_id' , $chatId)->first();
            if($user)
            {
              $usertext = "Siz allaqachon ro'yxatdan o'tgansiz";
              Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $usertext,
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => '📋 Kurs tanlash'], ['text' => '💬 O'qituvchilik qilish']],
                    ],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => false
                ])
              ]);
            }


        }else{




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
                ]),
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ]);


        }


    } catch (\ErrorException $e) {
        return "Xatolik yuzberdi" . $e;
    }
    }
}
