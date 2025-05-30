<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Tambah_ODP extends CI_Controller
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
        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_ODP');
        $this->load->view('admin/Data_ODP/V_Tambah_ODP');
        $this->load->view('template/admin/V_Footer');
    }

    public function TambahODPSave()
    {
        // Ambil data dari form
        $input = $this->input->post();

        // Validasi Form
        $this->form_validation->set_rules('nama_odp', 'Nama ODP', 'required');
        $this->form_validation->set_message('required', 'Masukkan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/V_Header');
            $this->load->view('template/admin/V_Sidebar');
            $this->load->view('template/admin/V_Get_ODP');
            $this->load->view('admin/Data_ODP/V_Tambah_ODP');
            $this->load->view('template/admin/V_Footer');
            return;
        }

        // Cek duplikat
        $isDuplicateName = $this->M_Area->CheckDuplicateArea($input['nama_odp']);

        if ($isDuplicateName) {
            $this->session->set_flashdata(
                'duplicate_odp',
                'Nama Area / ODP sudah tersedia <br> mohon untuk di check kembali'
            );

            redirect('admin/Data_ODP/C_Tambah_ODP');
            return;
        }

        // Data pelanggan
        $data_ODP = [
            'id_area'           => $input['id_area'],
            'nama_area'         => $input['nama_odp'],
            'created_at'        => date('Y-m-d H:i:s')
        ];

        // Simpan ke DB
        $this->M_CRUD->insertData($data_ODP, 'data_area');

        // Notifikasi sukses
        $this->session->set_flashdata('Tambah_icon', 'success');
        $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

        redirect('admin/Data_ODP/C_Data_ODP');
    }
}
