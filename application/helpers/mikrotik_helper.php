<?php

defined('BASEPATH') or exit('No direct script access allowed');

function formatBytes($bytes, $decimal = null)
{
    $satuan = ["bytes", 'kb', 'mb', 'gb', 'tb'];
    $i = 0;

    while ($bytes > 1024) {
        $bytes /= 1024;
        $i++;
    }

    return round($bytes, $decimal) . " " . $satuan[$i];
}

function Connect_Kraksaaan()
{
    $CI = &get_instance();

    $ipMikrotik       = '103.189.60.31:8799';
    $usernameMikrotik = 'adminnakasy';
    $passwordMikrotik = 'nakasyinfly';

    $api = new RouterosAPI();

    try {
        if (!$api->connect($ipMikrotik, $usernameMikrotik, $passwordMikrotik)) {
            throw new Exception("Gagal terhubung ke Mikrotik Kraksaan. Silakan periksa koneksi atau kredensial.");
        }

        // Jika tidak ada data PPP
        $pppSecrets = $api->comm('/ppp/secret/print');
        if (count($pppSecrets) == 0) {
            $api->disconnect();
            throw new Exception("Tidak ada data PPP ditemukan di Mikrotik Kraksaan.");
        }

        return $api;
    } catch (Exception $e) {
        // Kembalikan null jika gagal, dan simpan pesan ke session untuk ditampilkan
        $CI->session->set_flashdata('mikrotik_error', $e->getMessage());
        return null;
    }
}


function Connect_Paiton()
{
    $CI = &get_instance();

    $ipMikrotik         = '103.189.60.33:8799';
    $usernameMikrotik   = 'adminnakasy';
    $passwordMikrotik   = 'nakasyinfly';

    $api = new RouterosAPI();
    try {
        if (!$api->connect($ipMikrotik, $usernameMikrotik, $passwordMikrotik)) {
            throw new Exception("Gagal terhubung ke Mikrotik Paiton. Silakan periksa koneksi atau kredensial.");
        }

        // Jika tidak ada data PPP
        $pppSecrets = $api->comm('/ppp/secret/print');
        if (count($pppSecrets) == 0) {
            $api->disconnect();
            throw new Exception("Tidak ada data PPP ditemukan di Mikrotik Paiton.");
        }

        return $api;
    } catch (Exception $e) {
        // Kembalikan null jika gagal, dan simpan pesan ke session untuk ditampilkan
        $CI->session->set_flashdata('mikrotik_error', $e->getMessage());
        return null;
    }
}
