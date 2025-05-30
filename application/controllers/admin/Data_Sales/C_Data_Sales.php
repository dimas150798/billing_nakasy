<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Data_Sales extends CI_Controller
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
        $data['Data_Sales']     = $this->M_Sales->DataSales();
        $data['Data_Divisi']    = $this->M_Jabatan->DataJabatan();

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_Sales');
        $this->load->view('admin/Data_Sales/V_Data_Sales', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function GetDataAjax()
    {
        $result = $this->M_Sales->DataSales();

        $no = 0;

        foreach ($result as $data_sales) {

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . ucwords(strtolower($data_sales['nama_sales'])) . '</div>';
            $row[] = '<div class="text-center">' . $data_sales['phone_sales'] . '</div>';
            $row[] = '<div class="text-center">' . $data_sales['nama_jabatan'] . '</div>';

            $row[] = '
            <div class="text-center">
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-sm rounded-3">
                        <li>
                            <a onclick="Edit_Data(' . $data_sales['id_sales'] . ')"class="dropdown-item text-black"><i class="bi bi-pencil-square"></i> Edit </a>
                        </li>
                        <li>
                            <a onclick="Delete_Data(' . $data_sales['id_sales'] . ')"class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete </a>
                        </li>
                    </ul>
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
