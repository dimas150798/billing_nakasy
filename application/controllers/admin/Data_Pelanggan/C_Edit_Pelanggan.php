<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Edit_Pelanggan extends CI_Controller
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

    public function Edit_Pelanggan($id_customer)
    {
        $data['Data_Pelanggan']  = $this->M_Pelanggan->Edit_Pelanggan($id_customer);
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_Data');
        $this->load->view('admin/Data_Pelanggan/V_Edit_Pelanggan', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function Edit_PelangganSave()
    {
        // Ambil semua input POST sekaligus
        $input = $this->input->post();

        // Validasi Form
        $this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('kode_customer', 'Kode Customer', 'required');
        $this->form_validation->set_rules('name_pppoe', 'Name PPPOE', 'required');
        $this->form_validation->set_rules('password_pppoe', 'Password PPPOE', 'required');
        $this->form_validation->set_rules('phone_customer', 'Phone Customer', 'required');
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('nama_area', 'Nama Area', 'required');
        $this->form_validation->set_rules('nama_sales', 'Nama Sales', 'required');
        $this->form_validation->set_rules('email_customer', 'Email Customer', 'required');
        $this->form_validation->set_rules('alamat_customer', 'Alamat Customer', 'required');
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
            $this->load->view('admin/Data_Pelanggan/V_Edit_Pelanggan', $data);
            $this->load->view('template/admin/V_Footer');
            return;
        }

        // Ambil data paket
        $paket = $this->M_Paket->Check_Idpaket($input['nama_paket']);

        // Update Mikrotik
        $mikrotikFunctions = [
            'Kraksaan' => 'Connect_Kraksaaan',
            'Paiton'   => 'Connect_Paiton'
        ];

        // if (isset($mikrotikFunctions[$input['kode_mikrotik']])) {
        //     $connectFunc = $mikrotikFunctions[$input['kode_mikrotik']];
        //     $api = $connectFunc();

        //     $api->comm('/ppp/secret/set', [
        //         ".id"       => $input['id_pppoe'],
        //         "name"      => $input['name_pppoe'],
        //         "password"  => $input['password_pppoe'],
        //         "service"   => "any",
        //         "profile"   => $paket->nama_paket,
        //         "comment"   => $input['deskripsi_customer']
        //     ]);

        //     $api->disconnect();
        // }

        // Data pelanggan yang akan diupdate
        $dataPelanggan = [
            'id_customer'         => $input['id_customer'],
            'kode_customer'       => $input['kode_customer'],
            'phone_customer'      => $input['phone_customer'],
            'nama_customer'       => $input['nama_customer'],
            'id_paket'            => $input['nama_paket'],
            'nama_paket'          => $paket->nama_paket,
            'name_pppoe'          => $input['name_pppoe'],
            'password_pppoe'      => $input['password_pppoe'],
            'alamat_customer'     => $input['alamat_customer'],
            'email_customer'      => $input['email_customer'],
            'start_date'          => $input['start_date'],
            'nama_area'           => $input['nama_area'],
            'deskripsi_customer'  => $input['deskripsi_customer'],
            'nama_sales'          => $input['nama_sales'],
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        // Update data pelanggan
        $this->M_CRUD->updateData('data_customer', $dataPelanggan, ['id_customer' => $input['id_customer']]);

        // Update data pembayaran (jika ada)
        $payment = $this->M_SudahLunas->Check_Payment($input['name_pppoe_session']);

        if ($payment) {
            $updateDataPayment = [
                'name_pppoe'   => $input['name_pppoe'],
                'gross_amount' => $paket->harga_paket,
                'nama_paket'   => $paket->nama_paket
            ];
            $condition = ['order_id' => $payment->order_id];

            $this->M_CRUD->updateData('data_pembayaran', $updateDataPayment, $condition);
            $this->M_CRUD->updateData('data_pembayaran_history', $updateDataPayment, $condition);
        }

        // Set notifikasi dan redirect
        $this->session->set_flashdata('Edit_icon', 'success');
        $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');
        redirect('admin/Data_Pelanggan/C_Data_Pelanggan');
    }
}
