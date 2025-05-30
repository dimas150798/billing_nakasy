<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Edit_ODP extends CI_Controller
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

    public function Edit_ODP($id_area)
    {
        $data['Data_ODP']  = $this->M_Area->EditArea($id_area);

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_ODP');
        $this->load->view('admin/Data_ODP/V_Edit_ODP', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function Edit_Save()
    {
        // Mengambil data post pada view
        $id_area                = $this->input->post('id_area');
        $nama_odp               = $this->input->post('nama_odp');

        // Menyimpan data ODP ke dalam array
        $data_odp = array(
            'nama_area'     => $nama_odp,
            'updated_at'     => date('Y-m-d H:i:s', time())
        );

        // Rules form validation
        $this->form_validation->set_rules('nama_odp', 'Nama ODP', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            // Jika form tidak valid, load view kembali
            $data['Data_ODP']  = $this->M_Area->EditArea(array('id_area' => $id_area));

            $this->load->view('template/admin/V_Header');
            $this->load->view('template/admin/V_Sidebar');
            $this->load->view('template/admin/V_Get_ODP');
            $this->load->view('admin/Data_ODP/V_Edit_ODP', $data);
            $this->load->view('template/admin/V_Footer');
        } else {
            // Jika form valid, lakukan update data
            $this->M_CRUD->updateData('data_area', $data_odp, array('id_area' => $id_area));

            // Notifikasi berhasil edit data
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            // Redirect ke halaman Data ODP
            redirect('admin/Data_ODP/C_Data_ODP');
        }
    }
}
