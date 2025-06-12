<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Tambah_Terminated extends CI_Controller
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

    public function Terminated_Pelanggan($id_customer)
    {
        $data['Data_Pelanggan']  = $this->M_Pelanggan->Edit_Pelanggan($id_customer);
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_Data');
        $this->load->view('admin/Pelanggan_Terminated/V_Tambah_Terminated', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function Terminated_PelangganSave()
    {
        // Ambil semua input POST sekaligus
        $input = $this->input->post();

        // Validasi Form
        $this->form_validation->set_rules('stop_date', 'Stop Date', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $data = [
                'Data_Pelanggan' => $this->M_Pelanggan->Edit_Pelanggan($input['id_customer']),
                'DataPaket'      => $this->M_Paket->DataPaket(),
                'DataArea'       => $this->M_Area->DataArea(),
                'DataSales'      => $this->M_Sales->DataSales()
            ];

            $this->load->view('template/admin/V_Header');
            $this->load->view('template/admin/V_Sidebar');
            $this->load->view('template/admin/V_Get_Data');
            $this->load->view('admin/Pelanggan_Terminated/V_Tambah_Terminated', $data);
            $this->load->view('template/admin/V_Footer');
            return;
        }

        // Ambil data paket
        $paket = 'EXPIRED';

        // Update Mikrotik
        $mikrotikFunctions = [
            'Kraksaan' => 'Connect_Kraksaaan',
            'Paiton'   => 'Connect_Paiton'
        ];

        if (isset($mikrotikFunctions[$input['kode_mikrotik']])) {
            $connectFunc = $mikrotikFunctions[$input['kode_mikrotik']];
            $api = $connectFunc();

            $api->comm('/ppp/secret/set', [
                ".id" => $input['id_pppoe'],
                "disabled" => 'true',
            ]);

            // disable active otomatis
            $api->comm("/ppp/active/print", ["?name" => $input['name_pppoe']]);
            $api->comm('/ppp/active/remove', [".id" => $input['id_pppoe']]);

            $api->disconnect();
        }

        // Data pelanggan yang akan diupdate
        $dataPelanggan = [
            'id_customer'         => $input['id_customer'],
            'stop_date'           => $input['stop_date'],
            'nama_paket'          => $paket,
            'updated_at'          => date('Y-m-d H:i:s'),
            'disabled'            => 'true'
        ];

        // Update data pelanggan
        $this->M_CRUD->updateData('data_customer', $dataPelanggan, ['id_customer' => $input['id_customer']]);

        // Set notifikasi dan redirect
        $this->session->set_flashdata(
            'registrasi_success',
            'Registrasi Pelanggan Berhasil'
        );

        redirect('admin/Data_Pelanggan/C_Data_Pelanggan');
    }
}
