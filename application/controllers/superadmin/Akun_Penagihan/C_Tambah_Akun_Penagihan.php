<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Tambah_Akun_Penagihan extends CI_Controller
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
        $data['Data_Login']    = $this->M_Login->DataLogin();
        $data['DataArea']       = $this->M_Area->DataArea();

        $this->load->view('template/superadmin/V_Header');
        $this->load->view('template/superadmin/V_Sidebar');
        $this->load->view('template/superadmin/V_Get_Penagihan');
        $this->load->view('superadmin/Akun_Penagihan/V_Tambah_Akun_Penagihan', $data);
        $this->load->view('template/superadmin/V_Footer');
    }

    public function TambahAkunPenagihanSave()
    {
        // Ambil data dari form
        $input = $this->input->post();

        // Validasi Form
        $this->form_validation->set_rules('email_login_akun', 'Email', 'required');
        $this->form_validation->set_rules('nama_penagihan', 'Nama', 'required');
        $this->form_validation->set_rules('area_1', 'Area', 'required');
        $this->form_validation->set_message('required', 'Masukkan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $data['Data_Akses']    = $this->M_AksesLogin->DataAksesLogin();

            $this->load->view('template/superadmin/V_Header');
            $this->load->view('template/superadmin/V_Sidebar');
            $this->load->view('template/superadmin/V_Get_Penagihan');
            $this->load->view('superadmin/Akun_Penagihan/V_Tambah_Akun_Penagihan', $data);
            $this->load->view('template/superadmin/V_Footer');
            return;
        }

        // Cek duplikat email
        $isDuplicateEmail = $this->M_Login->CheckDuplicateEmail($input['email_login_akun']);

        if ($isDuplicateEmail) {
            $this->session->set_flashdata(
                'duplicate_email',
                'Email sudah terdaftar. Silakan gunakan email lain.'
            );
            redirect('superadmin/Akses_Login/C_Tambah_Akses_Login');
            return;
        }

        // Data pelanggan
        $data_penagih = [
            'email_login'       => $input['email_login_akun'],
            'nama_penagih'      => $input['nama_penagihan'],
            'area_1'            => $input['area_1'],
            'area_2'            => $input['area_2'],
            'area_3'            => $input['area_3'],
            'area_4'            => $input['area_4'],
            'area_5'            => $input['area_5'],
            'created_at'        => date('Y-m-d H:i:s')
        ];

        // Simpan ke DB
        $this->M_CRUD->insertData($data_penagih, 'data_penagih');

        $this->session->set_flashdata(
            'tambah_success',
            'Menambah area akun penagihan'
        );

        redirect('superadmin/Akun_Penagihan/C_Akun_Penagihan');
    }
}
