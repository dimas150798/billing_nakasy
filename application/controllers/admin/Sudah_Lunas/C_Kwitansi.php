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
        $cluster = $this->session->userdata('cluster');

        // Daftar alamat dan telepon berdasarkan cluster
        $infoCluster = [
            'Kraksaan' => [
                'alamat'  => 'Jl. Kp. Melayu, Kapuran, Kraksaan Wetan No. 63, Kabupaten Probolinggo',
                'telepon' => '0812-129-954-04'
            ],
            'Paiton' => [
                'alamat'  => 'Jl. SMA Negeri 1 Paiton, Dusun Mega, Desa Sukodadi, Kecamatan Paiton',
                'telepon' => '0851-343-836-70'
            ]
        ];

        // Siapkan data berdasarkan cluster
        if (isset($infoCluster[$cluster])) {
            $data['Alamat']  = $infoCluster[$cluster]['alamat'];
            $data['Telepon'] = $infoCluster[$cluster]['telepon'];
        } else {
            $data['Alamat']  = 'Alamat tidak tersedia';
            $data['Telepon'] = 'Telepon tidak tersedia';
        }

        // Ambil data pelanggan dari model
        $data['Data_Pelanggan'] = $this->M_SudahLunas->Payment_OrderID($order_id);

        // Load tampilan
        $this->load->view('template/admin/V_Get_SudahLunas');
        $this->load->view('admin/Sudah_Lunas/V_Kwitansi', $data);
    }
}
