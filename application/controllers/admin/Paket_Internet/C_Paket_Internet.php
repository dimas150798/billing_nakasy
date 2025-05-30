<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Paket_Internet extends CI_Controller
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
        $data['Paket_Internet']    = $this->M_Paket->DataPaket();

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_Paket_Internet');
        $this->load->view('admin/Paket_Internet/V_Paket_Internet', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function GetDataAjax()
    {
        $result = $this->M_Paket->DataPaket();

        $no = 0;

        foreach ($result as $data_PaketInternet) {

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . $data_PaketInternet['nama_paket'] . '</div>';
            $row[] = '<div class="text-center">' . 'Rp. ' . number_format($data_PaketInternet['harga_paket'], 0, ',', '.') . '</div>';
            $row[] = '<div class="text-center">' . $data_PaketInternet['deskripsi_paket'] . '</div>';

            $row[] = '
            <div class="text-center">
                <button type="button" onclick="Edit_Data(' . $data_PaketInternet['id_paket'] . ')" 
                        class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square"></i> Edit </a>
                </button>
            </div>';

            $data[] = $row;
        }

        $ouput = array(
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }
}
