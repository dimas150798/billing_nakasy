<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Pelanggan_Terminated extends CI_Controller
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
        $data['Total_Pelanggan']    = $this->M_Pelanggan->Total_Pelanggan_Terminated($this->session->userdata('cluster'));

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_Terminated');
        $this->load->view('admin/Pelanggan_Terminated/V_Pelanggan_Terminated', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function GetDataAjax()
    {
        $result = $this->M_Pelanggan->DataPelanggan_Terminated($this->session->userdata('cluster'));

        $no = 0;

        foreach ($result as $dataCustomer) {

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = ucwords(strtolower($dataCustomer['nama_customer']));
            $row[] = $dataCustomer['name_pppoe'];
            $row[] = '<div class="text-center">' . $dataCustomer['phone_customer'] . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['nama_paket'] . '</div>';

            $data[] = $row;
        }

        $ouput = array(
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }
}
