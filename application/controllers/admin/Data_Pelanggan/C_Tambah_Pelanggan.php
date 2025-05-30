<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Tambah_Pelanggan extends CI_Controller
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
        // Memanggil mysql dari model
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('admin/Data_Pelanggan/V_Tambah_Pelanggan', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function TambahPelangganSave()
    {
        // Ambil data dari form
        $input = $this->input->post();
        $cluster = $this->session->userdata('cluster');

        $GetDataPaket = $this->M_Paket->Check_Idpaket($input['id_paket']);
        $nama_paket = $GetDataPaket->nama_paket;
        $price_paket = $GetDataPaket->harga_paket;

        $name_pppoe = rtrim($input['name_pppoe']);
        $password_pppoe = rtrim($input['password_pppoe']);

        // Validasi Form
        $this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('kode_customer', 'Kode Customer', 'required');
        $this->form_validation->set_rules('name_pppoe', 'Name PPPOE', 'required');
        $this->form_validation->set_rules('password_pppoe', 'Password PPPOE', 'required');
        $this->form_validation->set_rules('phone_customer', 'Phone Customer', 'required');
        $this->form_validation->set_rules('id_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('nama_area', 'Nama Area', 'required');
        $this->form_validation->set_rules('nama_sales', 'Nama Sales', 'required');
        $this->form_validation->set_rules('email_customer', 'Email Customer', 'required');
        $this->form_validation->set_rules('alamat_customer', 'Alamat Customer', 'required');
        $this->form_validation->set_message('required', 'Masukkan data terlebih dahulu...');

        $data = [
            'DataPaket' => $this->M_Paket->DataPaket(),
            'DataArea' => $this->M_Area->DataArea(),
            'DataSales' => $this->M_Sales->DataSales()
        ];

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/V_Header');
            $this->load->view('template/admin/V_Sidebar');
            $this->load->view('admin/Data_Pelanggan/V_Tambah_Pelanggan', $data);
            $this->load->view('template/admin/V_Footer');
            return;
        }

        // Cek duplikat
        $isDuplicateName = $this->M_Pelanggan->CheckDuplicatePelanggan($name_pppoe);
        $isDuplicateOrder = $this->M_Pelanggan->CheckDuplicateCode($input['order_id']);

        if ($isDuplicateName) {
            $this->session->set_flashdata(
                'duplicate_name',
                'Pelanggan sudah melakukan registrasi <br> mohon untuk di check kembali'
            );
            redirect('admin/Data_Pelanggan/C_Tambah_Pelanggan');
            return;
        }

        // Data pelanggan
        $dataPelanggan = [
            'id_customer'        => $input['id_customer'],
            'kode_customer'      => $input['kode_customer'],
            'phone_customer'     => $input['phone_customer'],
            'nama_customer'      => $input['nama_customer'],
            'nama_paket'         => $nama_paket,
            'id_paket'           => $input['id_paket'],
            'name_pppoe'         => $name_pppoe,
            'password_pppoe'     => $password_pppoe,
            'alamat_customer'    => $input['alamat_customer'],
            'email_customer'     => $input['email_customer'],
            'start_date'         => $input['start_date'],
            'nama_area'          => $input['nama_area'],
            'deskripsi_customer' => $input['deskripsi_customer'],
            'nama_sales'         => $input['nama_sales'],
            'kode_mikrotik'      => $cluster,
            'created_at'         => date('Y-m-d H:i:s')
        ];

        // Data pembayaran
        $order_id = $isDuplicateOrder ? $this->M_BelumLunas->invoice() : $input['order_id'];
        $dataPembayaran = [
            'order_id'         => $order_id,
            'gross_amount'     => $price_paket,
            'biaya_admin'      => '0',
            'name_pppoe'       => $name_pppoe,
            'nama_paket'       => $nama_paket,
            'nama_admin'       => 'Registrasi Baru',
            'keterangan'       => 'Registrasi Baru',
            'transaction_time' => date('Y-m-d H:i:s'),
            'status_code'      => '200'
        ];

        // Tambahkan ke Mikrotik
        $this->_tambahKeMikrotik($cluster, $name_pppoe, $password_pppoe, $nama_paket, $input['deskripsi_customer']);

        // Simpan ke DB
        $this->M_CRUD->insertData($dataPelanggan, 'data_customer');
        $this->M_CRUD->insertData($dataPembayaran, 'data_pembayaran');
        $this->M_CRUD->insertData($dataPembayaran, 'data_pembayaran_history');

        $cluster = $this->session->userdata('cluster');

        $connectFunctions = [
            'Kraksaan' => 'Connect_Kraksaaan',
            'Paiton'   => 'Connect_Paiton'
        ];

        // Pastikan hanya menjalankan cluster yang sesuai
        if (isset($connectFunctions[$cluster])) {
            $api = $connectFunctions[$cluster]();
            if ($api === null) {
                redirect('C_FormLogin');
                return;
            }

            // Eksekusi berdasarkan cluster yang terhubung
            if ($cluster === 'Kraksaan') {
                $this->M_Mikrotik_Kraksaan->index();
            } elseif ($cluster === 'Paiton') {
                $this->M_Mikrotik_Paiton->index();
            }
        }

        $this->session->set_flashdata(
            'registrasi_success',
            'Registrasi Pelanggan Berhasil'
        );

        redirect('admin/Data_Pelanggan/C_Data_Pelanggan');
    }

    // Fungsi bantu untuk tambah ke Mikrotik
    private function _tambahKeMikrotik($cluster, $name, $pass, $profile, $comment)
    {
        $api = null;
        if ($cluster === 'Kraksaan') {
            $api = Connect_Kraksaaan();
        } elseif ($cluster === 'Paiton') {
            $api = Connect_Paiton();
        }

        if ($api) {
            $api->comm('/ppp/secret/add', [
                'name'     => $name,
                'password' => $pass,
                'service'  => 'any',
                'profile'  => $profile,
                'comment'  => $comment,
            ]);
            $api->disconnect();
        }
    }
}
