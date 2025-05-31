<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Edit_Akses_Login extends CI_Controller
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

    public function Edit_Login($id_login)
    {
        $data['Data_Login']  = $this->M_Login->EditLogin($id_login);
        $data['Data_Akses']    = $this->M_AksesLogin->DataAksesLogin();

        $this->load->view('template/superadmin/V_Header');
        $this->load->view('template/superadmin/V_Sidebar');
        $this->load->view('template/superadmin/V_Get_Login');
        $this->load->view('superadmin/Akses_Login/V_Edit_Akses_Login', $data);
        $this->load->view('template/superadmin/V_Footer');
    }

    public function Edit_Save()
    {
        // Ambil input sekaligus dalam array
        $input = $this->input->post(null, true);

        // Validasi Form
        $this->form_validation->set_rules('email_login', 'Email', 'required');
        $this->form_validation->set_rules('password_login', 'Password', 'required');
        $this->form_validation->set_rules('id_akses', 'Id Akses', 'required');
        $this->form_validation->set_rules('cluster', 'Cluster', 'required');
        $this->form_validation->set_message('required', 'Masukkan data terlebih dahulu...');

        if ($this->form_validation->run() === false) {
            // Jika validasi gagal, ambil data lama untuk ditampilkan kembali
            $data['Data_Login']  = $this->M_Login->EditLogin($input['id_login']);
            $data['Data_Akses']  = $this->M_AksesLogin->DataAksesLogin();

            $this->load->view('template/superadmin/V_Header');
            $this->load->view('template/superadmin/V_Sidebar');
            $this->load->view('template/superadmin/V_Get_Login');
            $this->load->view('superadmin/Akses_Login/V_Edit_Akses_Login', $data);
            $this->load->view('template/superadmin/V_Footer');
        } else {
            // Data yang akan diupdate
            $data_login = [
                'email_login'     => $input['email_login'],
                'password_login'  => $input['password_login'],
                'id_akses'        => $input['id_akses'],
                'cluster'         => $input['cluster'],
                'created_at'      => date('Y-m-d H:i:s')
            ];

            // Update data ke database
            $this->M_CRUD->updateData('data_login', $data_login, ['id_login' => $input['id_login']]);

            $this->session->set_flashdata(
                'duplicate_email',
                'edit akses login berhasil'
            );

            redirect('superadmin/Akses_login/C_Data_Login');
        }
    }
}
