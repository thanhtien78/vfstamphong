<?php
namespace App\Core;

use App\Models\Setting;
use Exception;

/**
 * VinFast Notification Integration Service
 */
class Notification {
    /**
     * Sends a notification message to Telegram using Bot API settings.
     */
    public static function sendTelegram($message) {
        try {
            // Retrieve settings values via Setting Model
            $botToken = Setting::get('telegram_bot_token');
            $chatId = Setting::get('telegram_chat_id');

            // Fallback to .env values if database values are empty
            if (empty($botToken)) {
                $botToken = Config::getEnv('TELEGRAM_BOT_TOKEN');
            }
            if (empty($chatId)) {
                $chatId = Config::getEnv('TELEGRAM_CHAT_ID');
            }

            if (empty($botToken) || empty($chatId)) {
                return false;
            }

            $url = "https://api.telegram.org/bot" . urlencode($botToken) . "/sendMessage";
            $data = [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                    'timeout' => 5
                ]
            ];

            $context = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            return $result !== false;
        } catch (Exception $e) {
            return false;
        }
    }
}
