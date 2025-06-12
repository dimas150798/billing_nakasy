<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Terminasi_Kraksaan extends CI_Controller
{

    public function index()
    {
        // Data jabatan
        $data_jabatan = [
            'nama_jabatan' => 'Test',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        // Simpan data ke tabel 'data_jabatan'
        $this->M_CRUD->insertData($data_jabatan, 'data_jabatan');
    }

    public function Terminasi()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan = date("m");
        $tahun = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $Terminasi = $this->M_Mikrotik_Kraksaan->Terminasi_Kraksaan($bulan, $tahun, $TanggalAkhir);

        echo $Terminasi;
    }
}
