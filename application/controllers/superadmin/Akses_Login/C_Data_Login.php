<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Data_Login extends CI_Controller
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
        $this->load->view('template/superadmin/V_Header');
        $this->load->view('template/superadmin/V_Sidebar');
        $this->load->view('template/superadmin/V_Get_Login');
        $this->load->view('superadmin/Akses_Login/V_Data_Login');
        $this->load->view('template/superadmin/V_Footer');
    }

    public function GetDataAjax()
    {
        $result = $this->M_Login->DataLogin();

        $no = 0;

        foreach ($result as $dataLogin) {

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . $dataLogin['email_login'] . '</div>';
            $row[] = '<div class="text-center">' . $dataLogin['password_login'] . '</div>';
            $row[] = '<div class="text-center">' . $dataLogin['nama_akses'] . '</div>';
            $row[] = '<div class="text-center">' . $dataLogin['cluster'] . '</div>';

            $row[] = '
            <div class="text-center">
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-sm rounded-3">
                        <li>
                            <a onclick="Edit_Data(' . $dataLogin['id_login'] . ')" class="dropdown-item text-black"><i class="bi bi-pencil-square"></i> Edit </a>
                        </li>
                        <li>
                            <a onclick="Delete_Data(' . $dataLogin['id_login'] . ')" class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete </a>
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
