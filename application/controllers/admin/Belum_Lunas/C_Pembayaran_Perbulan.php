<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Pembayaran_Perbulan extends CI_Controller
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

    public function index()
    {
        // Kirim data ke view (jika masih mau ditampilkan)
        $data['Data_Pelanggan'] = $this->session->userdata('data_pelanggan');

        // Load tampilan
        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_BelumLunas');
        $this->load->view('admin/Belum_Lunas/V_Pembayaran_Perbulan', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function Payment($id_customer)
    {
        // Ambil data pelanggan dari model
        $data_pelanggan = $this->M_BelumLunas->Payment($id_customer);

        // Simpan data ke session
        $this->session->set_userdata('data_pelanggan', $data_pelanggan);

        // Kirim data ke view (jika masih mau ditampilkan)
        $data['Data_Pelanggan'] = $data_pelanggan;
        $data['DataSales']      = $this->M_Sales->DataSales();

        // Load tampilan
        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_BelumLunas');
        $this->load->view('admin/Belum_Lunas/V_Pembayaran_Perbulan', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function PaymentSave()
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Ambil data POST dan session
        $post = $this->input->post();
        $cluster = $this->session->userdata('cluster');

        // Ambil bulan dan tahun dari transaction_time
        [$tahun, $bulan] = array_map('intval', explode('-', $post['transaction_time']));

        // Cek duplikasi pembayaran
        $duplicate = $this->M_BelumLunas->CheckDuplicatePayment($bulan, $tahun, $post['name_pppoe']);
        if (
            $duplicate &&
            $duplicate->bulan_payment == $bulan &&
            $duplicate->tahun_payment == $tahun &&
            $duplicate->name_pppoe === $post['name_pppoe']
        ) {
            $this->session->set_flashdata(
                'duplicate_transaksi',
                'Pelanggan sudah melakukan <br> Pembayaran di bulan <b>' . $months[$bulan] . '</b> ' . $tahun
            );
            redirect('admin/Belum_Lunas/C_Pembayaran_Perbulan/Payment/' . $post['id_customer']);
            return;
        }

        // Data pembayaran
        $paymentData = [
            'order_id'         => $post['order_id'],
            'gross_amount'     => $post['gross_amount'],
            'biaya_admin'      => $post['biaya_admin'],
            'name_pppoe'       => $post['name_pppoe'],
            'nama_paket'       => $post['nama_paket'],
            'nama_admin'       => $post['nama_sales'],
            'keterangan'       => $post['keterangan'],
            'transaction_time' => $post['transaction_time'],
            'expired_date'     => $post['transaction_time'],
            'status_code'      => 200,
        ];

        // Fungsi koneksi Mikrotik sesuai cluster
        $connectFunctions = [
            'Kraksaan' => 'Connect_Kraksaaan',
            'Paiton'   => 'Connect_Paiton'
        ];

        if (isset($connectFunctions[$cluster])) {
            $connectFunc = $connectFunctions[$cluster];
            $api = $connectFunc();

            if ($api) {
                // Aktifkan akun
                $api->comm('/ppp/secret/set', [
                    '.id' => $post['id_pppoe'],
                    'disabled' => 'false',
                ]);
                $api->disconnect();

                // Jalankan model sesuai cluster
                $modelMap = [
                    'Kraksaan' => $this->M_Mikrotik_Kraksaan,
                    'Paiton'   => $this->M_Mikrotik_Paiton
                ];
                $modelMap[$cluster]->index();
            } else {
                redirect('C_FormLogin');
                return;
            }
        }

        // Simpan ke database (dua tabel)
        $this->M_CRUD->insertData($paymentData, 'data_pembayaran');
        $this->M_CRUD->insertData($paymentData, 'data_pembayaran_history');

        // Notifikasi sukses
        $this->session->set_flashdata(
            'success_transaksi',
            'Pembayaran Pelanggan <b>' . $post['nama_customer'] . '</b> Berhasil <br> Di bulan <b>' . $months[$bulan] . '</b> ' . $tahun
        );

        redirect('admin/Belum_Lunas/C_Belum_Lunas');
    }
}
