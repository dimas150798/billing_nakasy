<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Kwitansi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email') == null) {

            // Notifikasi Login Terlebih Dahulu
            $this->session->set_flashdata('BelumLogin_icon', 'error');
            $this->session->set_flashdata('BelumLogin_title', 'Login Terlebih Dahulu');

            redirect('C_FormLogin');
        }
    }

    public function Kwitansi($order_id)
    {
        // Ambil bulan dan tahun dari session
        $bulan = $this->session->userdata('bulanGET') ?: $this->session->userdata('bulan');
        $tahun = $this->session->userdata('tahunGET') ?: $this->session->userdata('tahun');

        // Ambil data pelanggan dari model
        $data['Data_Pelanggan'] = $this->M_SudahLunas->Payment_OrderID($order_id);

        // Load tampilan
        $this->load->view('template/admin/V_Get_SudahLunas');
        $this->load->view('admin/Sudah_Lunas/V_Kwitansi', $data);
    }
}
