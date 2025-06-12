<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Send_Telegram extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries or models here
        $this->load->helper('date');
    }

    public function on_up()
    {
        $user = $this->input->post('name');
        $ip = $this->input->post('ip');
        $uptime = $this->input->post('uptime');
        $caller = $this->input->post('caller');
        $datetime = mdate('%d-%m-%Y %H:%i:%s', now('Asia/Jakarta'));

        // Format pesan
        $message = "✅ PPPoE CONNECTED\n";
        $message .= "🕒 Tanggal: $datetime\n";
        $message .= "👤 User: $user\n";
        $message .= "📡 IP: $ip\n";
        $message .= "⏱ Uptime: $uptime\n";
        $message .= "📲 Caller ID: $caller";

        // Simpan ke log
        log_message('info', $message);

        // Kirim ke Telegram
        $this->send_telegram($message);

        echo "UP Event Processed";
    }

    public function on_down()
    {
        $user = $this->input->post('name');
        $last_disconnect = $this->input->post('last-disconnect-reason');
        $last_logout = $this->input->post('last-logged-out');
        $last_called = $this->input->post('last-caller-id');
        $datetime = mdate('%d-%m-%Y %H:%i:%s', now('Asia/Jakarta'));

        // Buat pesan Telegram
        $message = "🚫 PPPoE DISCONNECTED\n";
        $message .= "🕒 Tanggal: $datetime\n";
        $message .= "👤 User: $user\n";
        $message .= "📲 Last Caller: $last_called\n";
        $message .= "❌ Reason: $last_disconnect";

        // Log ke file
        log_message('error', $message);

        // Kirim ke Telegram
        $this->send_telegram($message);

        echo "DOWN Event Processed";
    }

    // Contoh fungsi kirim telegram jika ingin diaktifkan
    private function send_telegram($message)
    {
        $token = '7935905626:AAEvyQjXk-JpIhdQv7ffIGkDIoiFRJiL6UM';
        $chat_id = '-4660175011';

        $url = "https://api.telegram.org/bot$token/sendMessage";
        $data = array(
            'chat_id' => $chat_id,
            'text' => $message
        );

        $this->load->library('curl');
        $this->curl->simple_post($url, $data);
    }
}
