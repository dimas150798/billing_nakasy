<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Data_ODP extends CI_Controller
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
        $this->load->view('template/admin/V_Get_ODP');
        $this->load->view('admin/Data_ODP/V_Data_ODP', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function GetDataAjax()
    {
        $result = $this->M_Area->DataArea();

        $no = 0;

        foreach ($result as $data_Area) {

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . ucwords(strtolower($data_Area['nama_area'])) . '</div>';
            $row[] = '
            <div class="text-center">
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-sm rounded-3">
                        <li>
                            <a onclick="Edit_Data(' . $data_Area['id_area'] . ')"class="dropdown-item text-black"><i class="bi bi-pencil-square"></i> Edit </a>
                        </li>
                        <li>
                            <a onclick="Delete_Data(' . $data_Area['id_area'] . ')"class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete </a>
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
