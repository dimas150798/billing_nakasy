<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Telegram extends CI_Controller
{

    private $token = '7935905626:AAEvyQjXk-JpIhdQv7ffIGkDIoiFRJiL6UM';
    public function __construct()
    {
        parent::__construct();
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    // Webhook endpoint yang dipanggil Telegram
    public function bot_start()
    {
        $input = file_get_contents('php://input');
        $update = json_decode($input, true);

        if (isset($update['message'])) {
            $chat_id  = $update['message']['chat']['id'];
            $text     = $update['message']['text'];
            $username = $update['message']['from']['username'] ?? 'unknown';

            // Respon sederhana
            $balasan = ($text === '/start') ?
                "Halo @$username, selamat datang di Bot CI3 di shared hosting! 🚀" :
                "Kamu mengirim: $text";

            $this->sendMessage($chat_id, $balasan);
        }
    }

    private function sendMessage($chat_id, $text)
    {
        $url = $this->apiUrl . "sendMessage";
        $data = [
            'chat_id' => $chat_id,
            'text' => $text
        ];

        // Gunakan cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        curl_close($ch);
    }
}
