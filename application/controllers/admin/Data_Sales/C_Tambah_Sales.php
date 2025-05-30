<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Tambah_Sales extends CI_Controller
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
        $this->load->view('admin/Data_Sales/V_Tambah_Sales', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function TambahSalesSave()
    {
        // Ambil data dari form
        $input = $this->input->post();

        // Validasi Form
        $this->form_validation->set_rules('nama_pegawai', 'Nama Sales', 'required');
        $this->form_validation->set_rules('phone_sales', 'Phone Sales', 'required');
        $this->form_validation->set_rules('id_jabatan', 'id Jabatan', 'required');
        $this->form_validation->set_message('required', 'Masukkan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/V_Header');
            $this->load->view('template/admin/V_Sidebar');
            $this->load->view('template/admin/V_Get_Sales');
            $this->load->view('admin/Data_Sales/V_Tambah_Sales');
            $this->load->view('template/admin/V_Footer');
            return;
        }

        // Cek duplikat
        $isDuplicateName = $this->M_Sales->CheckDuplicateSales($input['nama_pegawai']);

        if ($isDuplicateName) {
            $this->session->set_flashdata(
                'duplicate_sales',
                'Nama Sales / Penagih sudah tersedia <br> mohon untuk di check kembali'
            );

            redirect('admin/Data_Sales/C_Tambah_sales');
            return;
        }

        // Data pelanggan
        $data_Sales = [
            'id_sales'           => $input['id_sales'],
            'nama_sales'         => $input['nama_pegawai'],
            'phone_sales'        => $input['phone_sales'],
            'id_jabatan'         => $input['id_jabatan'],
            'created_at'         => date('Y-m-d H:i:s')
        ];

        // Simpan ke DB
        $this->M_CRUD->insertData($data_Sales, 'data_sales');

        // Notifikasi sukses
        $this->session->set_flashdata('Tambah_icon', 'success');
        $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

        redirect('admin/Data_Sales/C_Data_Sales');
    }
}
