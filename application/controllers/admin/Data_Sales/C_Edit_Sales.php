<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Edit_Sales extends CI_Controller
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

    public function Edit_Sales($id_sales)
    {
        $data['Data_Sales']  = $this->M_Sales->EditSales($id_sales);
        $data['Data_Divisi']    = $this->M_Jabatan->DataJabatan();


        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_Sales');
        $this->load->view('admin/Data_Sales/V_Edit_Sales', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function Edit_Save()
    {
        // Mengambil data post pada view
        $id_sales                = $this->input->post('id_sales');
        $nama_pegawai               = $this->input->post('nama_pegawai');
        $phone_sales               = $this->input->post('phone_sales');
        $id_jabatan               = $this->input->post('id_jabatan');

        // Menyimpan data ODP ke dalam array
        $data_sales = array(
            'nama_sales'     => $nama_pegawai,
            'phone_sales'     => $phone_sales,
            'id_jabatan'     => $id_jabatan,
            'updated_at'     => date('Y-m-d H:i:s', time())
        );

        // Rules form validation
        $this->form_validation->set_rules('nama_pegawai', 'Nama Sales', 'required');
        $this->form_validation->set_rules('phone_sales', 'Phone Sales', 'required');
        $this->form_validation->set_rules('id_jabatan', 'Id Jabatan', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            // Jika form tidak valid, load view kembali
            $data['Data_Sales']  = $this->M_Sales->EditSales($id_sales);
            $data['Data_Divisi']    = $this->M_Jabatan->DataJabatan();

            $this->load->view('template/admin/V_Header');
            $this->load->view('template/admin/V_Sidebar');
            $this->load->view('template/admin/V_Get_Sales');
            $this->load->view('admin/Data_Sales/V_Tambah_Sales', $data);
            $this->load->view('template/admin/V_Footer');
        } else {
            // Jika form valid, lakukan update data
            $this->M_CRUD->updateData('data_sales', $data_sales, array('id_sales' => $id_sales));

            // Notifikasi berhasil edit data
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            // Redirect ke halaman Data ODP
            redirect('admin/Data_Sales/C_Data_Sales');
        }
    }
}
