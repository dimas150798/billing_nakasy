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

    private function cekMikrotik($pppoe_name)
    {
        $api = Connect_Kraksaaan(); // Asumsikan ini sudah mengembalikan objek RouterosAPI yang terkoneksi

        if (!$api) return false; // gagal konek

        $api->write('/ppp/active/print', false);
        $api->write('?name=' . $pppoe_name, true);
        $result = $api->read();

        return !empty($result); // TRUE jika user aktif (online)
    }

    private function cekPelanggan($chat_id, $kode)
    {
        $data = $this->M_Pelanggan->Name_PPPOE($kode);

        if (!$data) {
            $this->sendMessage($chat_id, "❌ Data pelanggan dengan kode *$kode* tidak ditemukan.");
            return;
        }

        $api = Connect_Kraksaaan();
        $ip = $caller = $uptime = $lastdisc = $lastlogout = $lastcaller = '-';

        $status_login = 'Offline 🔴';

        if ($api) {
            // Cek apakah user aktif di Mikrotik
            $api->write('/ppp/active/print', false);
            $api->write('?name=' . $data->name_pppoe, true);
            $activeData = $api->read();

            if (!empty($activeData)) {
                $aktif = $activeData[0];
                $ip = $aktif['address'] ?? '-';
                $caller = $aktif['caller-id'] ?? '-';
                $uptime = $aktif['uptime'] ?? '-';
                $status_login = 'Online 🟢';
            }

            // Ambil data secret (last disconnect, logout, caller)
            $api->write('/ppp/secret/print', false);
            $api->write('?name=' . $data->name_pppoe, true);
            $secretData = $api->read();

            if (!empty($secretData)) {
                $s = $secretData[0];
                $lastdisc   = $s['last-disconnected'] ?? '-';
                $lastlogout = $s['last-logged-out'] ?? '-';
                $lastcaller = $s['last-caller-id'] ?? '-';
            }

            $api->disconnect();
        }

        $status_langganan = ($data->disabled == '0' || $data->disabled == 'false') ? 'Aktif ✅' : 'Nonaktif ❌';

        $msg = "🧑 *Nama:* $data->nama_customer\n"
            . "📶 *Status Langganan:* $status_langganan\n"
            . "🔌 *Status Mikrotik:* $status_login\n"
            . "📦 *Paket:* $data->nama_paket\n"
            . "📍 *Alamat:* $data->alamat_customer\n\n"
            . "🌐 *IP:* `$ip`\n"
            . "📞 *Caller:* `$caller`\n"
            . "⏱ *Uptime:* `$uptime`\n"
            . "📤 *Last Logout:* `$lastlogout`\n"
            . "📴 *Last Disconnect:* `$lastdisc`\n"
            . "📞 *Last Caller ID:* `$lastcaller`";

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
