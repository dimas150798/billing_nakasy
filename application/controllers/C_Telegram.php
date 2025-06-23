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

    public function botWebhook()
    {
        $input = file_get_contents('php://input');
        $update = json_decode($input, true);

        if (isset($update['message'])) {
            $chat_id  = $update['message']['chat']['id'];
            $text     = trim($update['message']['text']);
            $username = $update['message']['from']['username'] ?? 'pengguna';

            if (strtolower($text) === '/start') {
                $pesan = "Halo @$username! 👋\n\n"
                    . "Selamat datang di Bot Billing Nakasy.\n"
                    . "Perintah yang tersedia:\n"
                    . "• `/cek [kode]` — untuk cek status pelanggan\n"
                    . "• `/help` — bantuan";
                $this->sendMessage($chat_id, $pesan);
            } elseif (preg_match('/^\/cek\s+([a-zA-Z0-9_-]+)$/i', $text, $matches)) {
                $kode = $matches[1];
                $this->cekPelanggan($chat_id, $kode);
            } else {
                $this->sendMessage($chat_id, "⚠️ Gunakan format: `/cek [kode_customer]` atau /start");
            }
        }

        // Penting! Beri response ke Telegram agar tidak timeout
        http_response_code(200);
        exit('OK');
    }

    private function cekPelanggan($chat_id, $kode)
    {
        $data = $this->M_Pelanggan->Name_PPPOE($kode);

        if ($data) {
            $status = ($data->disabled == '0' || $data->disabled == 'false') ? 'Aktif ✅' : 'Nonaktif ❌';

            $msg = "🧑 *Nama:* $data->nama_customer\n"
                . "📶 *Status:* $status\n"
                . "📦 *Paket:* $data->nama_paket\n"
                . "📍 *Alamat:* $data->alamat_customer";
        } else {
            $msg = "❌ Data pelanggan dengan kode *$kode* tidak ditemukan.";
        }

        $this->sendMessage($chat_id, $msg);
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
