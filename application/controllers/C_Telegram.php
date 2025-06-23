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
                    . "• /cek [kode] — untuk cek status pelanggan\n"
                    . "• /pembayaran [kode] — untuk cek status pelanggan\n";
                $this->sendMessage($chat_id, $pesan);
            } elseif (preg_match('/^\/cek\s+([a-zA-Z0-9_-]+)$/i', $text, $matches)) {
                $kode = $matches[1];
                $this->cekPelanggan($chat_id, $kode);
            } elseif (preg_match('/^\/pembayaran\s+([a-zA-Z0-9_-]+)$/i', $text, $matches)) {
                $kode = $matches[1];
                $this->cekPembayaran($chat_id, $kode);
            } else {
                $this->sendMessage($chat_id, "⚠️ Perintah tidak dikenali. Gunakan `/start` untuk melihat bantuan.");
            }
        }

        // Penting! Beri response ke Telegram agar tidak timeout
        http_response_code(200);
        exit('OK');
    }

    private function getMikrotikLastStatus($pppoe_name)
    {
        $api = Connect_Kraksaaan();
        if (!$api) return [
            'online' => false,
            'ip' => '-',
            'caller' => '-',
            'uptime' => '-',
            'lastdisc' => '-',
            'lastlogout' => '-',
            'lastcaller' => '-'
        ];

        $result = [
            'online' => false,
            'ip' => '-',
            'caller' => '-',
            'uptime' => '-',
            'lastdisc' => '-',
            'lastlogout' => '-',
            'lastcaller' => '-'
        ];

        // Active check
        $api->write('/ppp/active/print', false);
        $api->write('?name=' . $pppoe_name, true);
        $active = $api->read();

        if (!empty($active)) {
            $user = $active[0];
            $result['online']  = true;
            $result['ip']      = $user['address'] ?? '-';
            $result['caller']  = $user['caller-id'] ?? '-';
            $result['uptime']  = $user['uptime'] ?? '-';
        }

        // Last disconnect info
        $api->write('/ppp/secret/print', false);
        $api->write('?name=' . $pppoe_name, true);
        $secret = $api->read();

        if (!empty($secret)) {
            $s = $secret[0];
            $result['lastdisc']   = $s['last-disconnected'] ?? '-';
            $result['lastlogout'] = $s['last-logged-out'] ?? '-';
            $result['lastcaller'] = $s['last-caller-id'] ?? '-';
        }

        $api->disconnect();
        return $result;
    }

    private function cekPelanggan($chat_id, $kode)
    {
        $data = $this->M_Pelanggan->Name_PPPOE($kode);

        // Gunakan regex untuk memisahkan nama dan index
        if (preg_match('/^(.*?)(\d+\/\d+\/\d+:\d+)$/', $data->deskripsi_customer, $match)) {
            $nama  = trim($match[1]);
            $index = $match[2];
        } else {
            $index = '-';
        }

        if (!$data) {
            $this->sendMessage($chat_id, "❌ Data pelanggan dengan kode *$kode* tidak ditemukan.");
            return;
        }

        $status_mikrotik = $this->getMikrotikLastStatus($data->name_pppoe);

        $status_login     = $status_mikrotik['online'] ? 'Online 🟢' : 'Offline 🔴';
        $msg = "---===[🖥️ Status Pelanggan]===---\n\n"
            . "🧑 Nama: " . ucwords(strtolower($data->nama_customer)) . "\n"
            . "🆔 ID Pelanggan: " . strtoupper($data->name_pppoe) . "\n"
            . "🌐 Paket: " . ucwords(strtolower($data->nama_paket)) . "\n"
            . "📶 Status: {$status_login}\n"
            . "📍 Alamat: " . ucwords(strtolower($data->alamat_customer)) . "\n\n";

        if ($status_mikrotik['online']) {
            $msg .= "🌐 IP: {$status_mikrotik['ip']}\n"
                . "📡 Index: $index\n"
                . "📞 Caller: {$status_mikrotik['caller']}\n"
                . "⏱ Uptime: {$status_mikrotik['uptime']}\n\n"
                . "---===[LIVE TRAFFIC]===---";
        } else {
            $msg .=  "📡 Index:  $index\n"
                . "📴 Last Disconnect: {$status_mikrotik['lastlogout']}\n"
                . "📞 Last Caller ID: {$status_mikrotik['lastcaller']}\n"
                . "---===[LIVE TRAFFIC]===---";
        }

        $this->sendMessage($chat_id, $msg);
    }

    private function cekPembayaran($chat_id, $kode)
    {
        $data = $this->M_Pelanggan->Name_PPPOE($kode);
        if (!$data) {
            $this->sendMessage($chat_id, "❌ Pelanggan dengan PPPoE *$kode* tidak ditemukan.");
            return;
        }

        $bulan = date('m');
        $tahun = date('Y');
        $periode = date('F Y');

        // Query manual pakai WHERE + LIKE
        $this->db->from('data_pembayaran');
        $this->db->where('name_pppoe', $data->name_pppoe);
        $this->db->where('MONTH(transaction_time)', $bulan);
        $this->db->where('YEAR(transaction_time)', $tahun);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $p = $query->row();
            $msg = "---===[💰 *Status Pembayaran]===---" . "\n\n"
                . "🆔 ID Pelanggan: " . strtoupper($data->name_pppoe) . "\n"
                . "🧑 Nama: " . ucwords(strtolower($data->nama_customer)) . "\n"
                . "🌐 Paket: " . ucwords($data->nama_paket) . "\n"
                . "📅 Periode: $periode\n"
                . "💵 Status: Sudah Dibayar ✅\n"
                . "📆 Tanggal Bayar: " . date('d M Y', strtotime($p->transaction_time)) . "\n"
                . "👨‍💼 Melalui: " . ucwords($p->nama_admin) . "\n\n"
                . "---===[BILLING NAKASY]===---";
        } else {
            $msg = "💰 *Status Pembayaran*\n\n"
                . "🆔 ID Pelanggan: " . strtoupper($data->name_pppoe) . "\n"
                . "🧑 Nama: " . ucwords(strtolower($data->nama_customer)) . "\n"
                . "🌐 Paket: " . ucwords($data->nama_paket) . "\n"
                . "📅 Periode: $periode\n"
                . "💵 Status: Belum Dibayar ❌" . "\n\n"
                . "---===[BILLING NAKASY]===---";
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
