<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Edit_Paket_Internet extends CI_Controller
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

    public function Edit_Paket_Internet($id_paket)
    {
        $data['Paket_Internet']  = $this->M_Paket->EditPaket($id_paket);

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_Paket_Internet');
        $this->load->view('admin/Paket_Internet/V_Edit_Paket_Internet', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function Edit_Save()
    {
        // Mengambil data post pada view
        $id_paket               = $this->input->post('id_paket');
        $nama_paket             = $this->input->post('nama_paket');
        $harga_paket            = $this->input->post('harga_paket');

        // Menyimpan data pelanggan ke dalam array
        $data_paket_internet = array(
            'nama_paket'     => $nama_paket,
            'harga_paket'    => $harga_paket,
            'updated_at'     => date('Y-m-d H:i:s', time())
        );

        // Kondisi update menggunakan id_customer
        $id_paket_internet = array(
            'id_paket'       => $id_paket
        );

        // Memanggil mysql dari model
        $data['Paket_Internet']  = $this->M_Paket->EditPaket($id_paket);

        // Rules form validation
        $this->form_validation->set_rules('harga_paket', 'Harga Paket', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/V_Header');
            $this->load->view('template/admin/V_Sidebar');
            $this->load->view('template/admin/V_Get_Paket_Internet');
            $this->load->view('admin/Paket_Internet/V_Edit_Paket_Internet', $data);
            $this->load->view('template/admin/V_Footer');
        } else {
            $this->M_CRUD->updateData('data_paket', $data_paket_internet, $id_paket_internet);

            // Notifikasi Login Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('admin/Paket_Internet/C_Paket_Internet');
        }
    }
}
