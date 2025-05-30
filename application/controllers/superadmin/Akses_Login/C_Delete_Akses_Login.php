<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Delete_Akses_Login extends CI_Controller
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

    public function Delete_Akses($id_login)
    {
        // Notifikasi Login Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        // Kondisi delete menggunakan id_customer
        $ID_Login = array(
            'id_login'       => $id_login
        );

        $this->M_CRUD->deleteData($ID_Login, 'data_login');

        $this->session->set_flashdata(
            'tambah_success',
            'Delete akses login berhasil'
        );

        redirect('superadmin/Akses_login/C_Data_Login');
    }
}
