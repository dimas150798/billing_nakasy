<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cek_Koneksi_Paiton extends CI_Controller
{
    public function index()
    {
        header('Content-Type: application/json');
        date_default_timezone_set("Asia/Jakarta");

        // Load RouterosAPI jika belum autoload
        $this->load->library('RouterosAPI');

        // Panggil fungsi Connect_Paiton
        $api = Connect_Paiton();

        if ($api) {
            // Berhasil konek, ambil identitas Router
            $identity = $api->comm('/system/identity/print');
            $board = $api->comm('/system/routerboard/print');
            $api->disconnect();

            echo json_encode([
                'status' => true,
                'message' => '✅ Berhasil terhubung ke Mikrotik Paiton',
                'identity' => $identity[0]['name'] ?? null,
                'board_name' => $board[0]['board-name'] ?? null,
                'model' => $board[0]['model'] ?? null,
                'serial_number' => $board[0]['serial-number'] ?? null,
                'firmware' => $board[0]['current-firmware'] ?? null,
                'time' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        } else {
            // Ambil pesan error dari flashdata jika ada
            $error = $this->session->flashdata('mikrotik_error');
            echo json_encode([
                'status' => false,
                'message' => $error ?: '❌ Gagal terhubung ke Mikrotik Paiton',
                'time' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        }
    }
}
