<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Delete_Lunas extends CI_Controller
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

    public function Delete_Lunas($order_id)
    {
        // Notifikasi Login Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        // Kondisi delete menggunakan id_customer
        $OrderID = array(
            'order_id'       => $order_id
        );

        $this->M_CRUD->deleteData($OrderID, 'data_pembayaran');
        $this->M_CRUD->deleteData($OrderID, 'data_pembayaran_history');

        // Notifikasi sukses
        $this->session->set_flashdata(
            'edit_success',
            'Delete Pembayaran Pelanggan Berhasil'
        );

        redirect('admin/Sudah_Lunas/C_Sudah_Lunas');
    }
}
