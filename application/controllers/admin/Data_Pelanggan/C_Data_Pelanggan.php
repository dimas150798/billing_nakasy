<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Data_Pelanggan extends CI_Controller
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
        $data['Total_Pelanggan']    = $this->M_Pelanggan->Total_Pelanggan($this->session->userdata('cluster'));
        $data['Pelanggan_Enable']    = $this->M_Pelanggan->Pelanggan_Enable($this->session->userdata('cluster'));
        $data['Pelanggan_Disable']    = $this->M_Pelanggan->Pelanggan_Disable($this->session->userdata('cluster'));

        $this->load->view('template/admin/V_Header_New');
        $this->load->view('template/admin/V_Sidebar_New');
        $this->load->view('template/admin/V_Get_Data');
        $this->load->view('admin/Data_Pelanggan/V_Data_Pelanggan', $data);
        $this->load->view('template/admin/V_Footer_New');
    }

    public function GetDataAjax()
    {
        $result = $this->M_Pelanggan->DataPelanggan($this->session->userdata('cluster'));

        $no = 0;

        foreach ($result as $dataCustomer) {
            $isDisabled = $dataCustomer['disabled'] === 'true';

            $Status_Mikrotik = $isDisabled
                ? '<span class="badge bg-danger px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">DISABLE</span>'
                : '<span class="badge bg-success px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">ENABLE</span>';

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . ucwords(strtolower($dataCustomer['nama_customer'])) . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['name_pppoe'] . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['nama_paket'] . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['phone_customer'] . '</div>';
            $row[] = '<div class="text-center keterangan-col">' . ucwords(strtolower($dataCustomer['alamat_customer'])) . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['nama_area'] . '</div>';
            $row[] = '<div class="text-center">' . $Status_Mikrotik . '</div>';

            $row[] =
                '<div class="text-center">
                        <div class="d-flex justify-content-center align-items-center flex-nowrap gap-1">
                        <button onclick="Edit_Data(\'' . $dataCustomer['id_customer'] . '\')" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Edit Data">
                        <i class="bi bi-pencil-square"></i>
                        </button>
                        <button onclick="Terminated_Data(' . $dataCustomer['id_customer'] . ')" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Kwitansi">
                            <i class="bi bi-person-x"></i>
                        </button>
                        <button onclick="Delete_Data(\'' . $dataCustomer['id_customer'] . '\')" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus Data">
                        <i class="bi bi-trash"></i>
                        </button>
                        </div>
                    </div>';





            $data[] = $row;
        }

        $ouput = array(
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }
}
