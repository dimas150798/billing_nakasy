<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Dashboard_Admin extends CI_Controller
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

        // Eksekusi berdasarkan cluster yang terhubung
        if ($cluster === 'Kraksaan') {
            $this->M_Mikrotik_Kraksaan->index();
        } elseif ($cluster === 'Paiton') {
            $this->M_Mikrotik_Paiton->index();
        }

        // Database
        $data['Total_Pelanggan']    = $this->M_Pelanggan->Total_Pelanggan($this->session->userdata('cluster'));
        $data['Pelanggan_Baru']     = $this->M_Pelanggan->Pelanggan_Baru($tahun, $bulan);

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('admin/V_Dashboard_Admin', $data);
        $this->load->view('template/admin/V_Footer');
    }
}
