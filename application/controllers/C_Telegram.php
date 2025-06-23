<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Send_Telegram extends CI_Controller
{

    private $token = '7935905626:AAEvyQjXk-JpIhdQv7ffIGkDIoiFRJiL6UM';

    public function __construct()
    {
        parent::__construct();
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    // Endpoint yang dipanggil oleh Telegram
    public function bot_start()
    {
        $input = file_get_contents('php://input');
        $update = json_decode($input, true);

        if (isset($update['message'])) {
            $chat_id = $update['message']['chat']['id'];
            $message = trim($update['message']['text']);
            $username = $update['message']['from']['username'] ?? 'unknown';

            // Logika respon
            if (strtolower($message) === '/start') {
                $reply = "Halo @$username! Selamat datang di bot CI3 ✅";
            } else {
                $reply = "Kamu bilang: $message";
            }

            $this->sendMessage($chat_id, $reply);
        }
    }

    private function sendMessage($chat_id, $text)
    {
        $data = [
            'chat_id' => $chat_id,
            'text'    => $text
        ];

        $ch = curl_init($this->apiUrl . "sendMessage");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        curl_close($ch);
    }
}
