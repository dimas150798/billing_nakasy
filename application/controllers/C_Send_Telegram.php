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
        $user        = $this->input->post('name');
        $profile     = $this->input->post('profile');
        $ip          = $this->input->post('ip');
        $caller      = $this->input->post('caller');
        $uptime      = $this->input->post('uptime');
        $active      = $this->input->post('active');
        $service     = $this->input->post('service');
        $lastdisc    = $this->input->post('lastdisc');
        $lastlogout  = $this->input->post('lastlogout');
        $lastcaller  = $this->input->post('lastcaller');

        $Pelanggan = $this->M_Pelanggan->Send_Telegram($lastcaller);

        $message = "✅ CONNECTED\n";
        $message .= "--===============---\n\n";

        $message .= "🆔 Kode Pelanggan: " . strtoupper($user) . "\n";
        $message .= "👤 User: " . ucwords(strtolower($Pelanggan->nama_customer)) . "\n";
        $message .= "📞 Telepon: $Pelanggan->phone_customer\n";
        $message .= "📍 Alamat: " . trim(ucwords(strtolower($Pelanggan->alamat_customer))) . "\n\n";

        $message .= "🔐 SN Modem: $Pelanggan->password_pppoe\n";
        $message .= "🧾 Profile: $profile\n";
        $message .= "📡 IP Client: $ip\n";
        $message .= "📲 Caller ID: $caller\n";
        $message .= "⏱ Uptime: $uptime\n";
        $message .= "👥 Total Active: $active Client\n";
        $message .= "📶 Service: $service\n";
        $message .= "❌ Last Disconnect: $lastdisc\n";
        $message .= "🔚 Last Logout: $lastlogout\n";
        $message .= "📲 Last Caller ID: $lastcaller\n\n";
        $message .= "--===[NAKASY]===---\n";

        // Simpan ke log
        log_message('info', $message);

        // Kirim ke Telegram
        $this->send_telegram($message);

        echo "UP Event Processed";
    }
    public function on_down()
    {
        $user         = $this->input->post('name');
        $lastdisc    = $this->input->post('lastdisc');
        $lastlogout  = $this->input->post('lastlogout');
        $lastcaller  = $this->input->post('lastcaller');

        // Ambil data pelanggan dari database
        $Pelanggan = $this->M_Pelanggan->Send_Telegram($lastcaller);

        // Format waktu
        $tanggal = mdate('%d-%m-%Y', now('Asia/Jakarta'));
        $jam     = mdate('%H:%i:%s', now('Asia/Jakarta'));

        // Buat isi pesan Telegram
        $message  = "🚫 DISCONNECTED\n";
        $message .= "--===============---\n\n";

        $message .= "📅 Tanggal: $tanggal\n";
        $message .= "🕒 Jam: $jam\n";
        $message .= "🆔 Kode Pelanggan: " . strtoupper($user) . "\n";
        $message .= "👤 User: " . ucwords(strtolower($Pelanggan->nama_customer)) . "\n";
        $message .= "📞 Telepon: $Pelanggan->phone_customer\n";
        $message .= "📍 Alamat: " . trim(ucwords(strtolower($Pelanggan->alamat_customer))) . "\n\n";

        $message .= "🔐 SN Modem: $Pelanggan->password_pppoe\n";
        $message .= "🧾 Profile: $Pelanggan->nama_paket\n";
        $message .= "❌ Last Disconnect: $lastdisc\n";
        $message .= "🔚 Last Logout: $lastlogout\n";
        $message .= "📲 Last Caller ID: $lastcaller\n\n";
        $message .= "--===[NAKASY]===---\n";

        // Kirim ke Telegram
        $this->send_telegram($message);

        // Simpan ke log
        log_message('info', $message);

        echo "Down Event Processed";
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

        // Native cURL (lebih stabil dari CI3 curl)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        // Debug: log response & error
        log_message('debug', "Telegram response: $response");
        log_message('error', "Telegram error: $error");
    }
}
