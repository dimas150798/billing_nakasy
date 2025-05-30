<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Dashboard_User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Mencegah caching agar tidak bisa kembali ke halaman setelah logout
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        if ($this->session->userdata('email') == null) {
            $this->session->set_flashdata('BelumLogin_icon', 'error');
            $this->session->set_flashdata('BelumLogin_title', 'Login Terlebih Dahulu');
            redirect('C_FormLogin');
        }
    }

    public function index()
    {
        // Mengambil Date Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $Today = date('Y-m-d');

        // Memisahkan Tanggal
        $Split_Date       = explode("-", $Today);
        $tahun          = $Split_Date[0];
        $bulan          = $Split_Date[1];

        $cluster = $this->session->userdata('cluster');

        $connectFunctions = [
            'Kraksaan' => 'Connect_Kraksaaan',
            'Paiton'   => 'Connect_Paiton'
        ];

        // Pastikan hanya menjalankan cluster yang sesuai
        if (isset($connectFunctions[$cluster])) {
            $api = $connectFunctions[$cluster](); // Memanggil fungsi koneksi sesuai cluster
            if ($api === null) {
                redirect('C_FormLogin'); // Jika API gagal terkoneksi, arahkan ke login
                return;
            }

            // Eksekusi berdasarkan cluster yang terhubung
            if ($cluster === 'Kraksaan') {
                $this->M_Mikrotik_Kraksaan->index();
            } elseif ($cluster === 'Paiton') {
                $this->M_Mikrotik_Paiton->index();
            }
        }

        $month = date("m");
        $year = date("Y");
        $tanggalAkhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $lastDate = "$tahun-$bulan-$tanggalAkhir";

        $checkLogin                 = $this->M_AkunPenagihan->CheckLogin($this->session->userdata('email'));

        $area_1                     = $checkLogin->area_1;
        $area_2                     = $checkLogin->area_2;
        $area_3                     = $checkLogin->area_3;
        $area_4                     = $checkLogin->area_4;
        $area_5                     = $checkLogin->area_5;

        // nama penagih
        $nama_penagih               = $checkLogin->nama_penagih;
        $Nominal_Tagihan            = $this->M_BelumLunasUser->NominalBelumLunas($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
        $Jumlah_Pelanggan           = $this->M_BelumLunasUser->JumlahBelumLunas($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
        $Nominal_Fee                = $Jumlah_Pelanggan * 3000;
        $Total_Akhir                = $Nominal_Tagihan->hargaPaket - $Nominal_Fee;

        $data['Jumlah_Pelanggan']   = $Jumlah_Pelanggan;
        $data['Nominal_Tagihan']    = $Nominal_Tagihan->hargaPaket;
        $data['Nominal_Fee']        = $Nominal_Fee;
        $data['Total_Akhir']        = $Total_Akhir;

        $this->load->view('template/user/V_Header');
        $this->load->view('template/user/V_Sidebar');
        $this->load->view('user/V_Dashboard_User', $data);
        $this->load->view('template/user/V_Footer');
    }
}
