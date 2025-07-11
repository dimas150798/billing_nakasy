<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cek_Koneksi_Paiton extends CI_Controller
{
    public function index()
    {
        header('Content-Type: application/json');

        $this->load->library('RouterosAPI_SSL');

        $ip = '103.189.60.33';
        $username = 'berlin';
        $password = '@infly2024';
        $port = 8729;

        if ($this->routerosapi_ssl->connect($ip, $username, $password, $port)) {
            $identity = $this->routerosapi_ssl->comm('/system/identity/print');
            $this->routerosapi_ssl->disconnect();

            echo json_encode([
                'status' => true,
                'message' => '✅ Berhasil konek ke Mikrotik via API-SSL',
                'identity' => $identity[0]['name'] ?? 'Unknown',
                'time' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        } else {
            echo json_encode([
                'status' => false,
                'message' => '❌ Gagal konek: ' . $this->routerosapi_ssl->error,
                'time' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        }
    }
}
