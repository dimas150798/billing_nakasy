<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Delete_Akun_Penagihan extends CI_Controller
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

    public function Delete_Akun($id_penagihan)
    {
        // Notifikasi Login Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        // Kondisi delete menggunakan id_customer
        $ID_Penagihan = array(
            'id_penagih'       => $id_penagihan
        );

        $this->M_CRUD->deleteData($ID_Penagihan, 'data_penagih');

        $this->session->set_flashdata(
            'tambah_success',
            'Delete akun penagihan berhasil'
        );

        redirect('superadmin/Akun_Penagihan/C_Akun_Penagihan');
    }
}
