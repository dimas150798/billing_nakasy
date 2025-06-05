<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Enable_Kraksaan extends CI_Controller
{

    public function Enable_Kraksaan()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan = date("m");
        $tahun = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $this->M_Mikrotik_Kraksaan->Enable_Kraksaan($bulan, $tahun, $TanggalAkhir);
    }

    public function Sinkron_Paiton()
    {
        $this->M_Mikrotik_Paiton->index();
    }
}
