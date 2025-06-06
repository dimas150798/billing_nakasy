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
        $this->load->view('template/user/V_Header');
        $this->load->view('template/user/V_Sidebar');
        $this->load->view('template/user/V_Get_BelumLunas');
        $this->load->view('user/Belum_Lunas/V_Pembayaran_Perbulan', $data);
        $this->load->view('template/user/V_Footer');
    }

    public function Payment($id_customer)
    {
        // Ambil data pelanggan dari model
        $data_pelanggan = $this->M_BelumLunas->Payment($id_customer);

        // Simpan data ke session
        $this->session->set_userdata('data_pelanggan', $data_pelanggan);

        // Kirim data ke view (jika masih mau ditampilkan)
        $data['Data_Pelanggan'] = $data_pelanggan;

        // Load tampilan
        $this->load->view('template/user/V_Header');
        $this->load->view('template/user/V_Sidebar');
        $this->load->view('template/user/V_Get_BelumLunas');
        $this->load->view('user/Belum_Lunas/V_Pembayaran_Perbulan', $data);
        $this->load->view('template/user/V_Footer');
    }

    public function PaymentSave()
    {
        $months = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $post = $this->input->post();
        $cluster = $this->session->userdata('cluster');
        $email = $this->session->userdata('email');

        // Ambil bulan & tahun dari transaction_time
        [$tahun, $bulan] = array_map('intval', explode("-", $post['transaction_time']));

        // Cek duplikat pembayaran
        $existingPayment = $this->M_BelumLunas->CheckDuplicatePayment($bulan, $tahun, $post['name_pppoe']);
        if ($existingPayment) {
            $this->session->set_flashdata(
                'duplicate_transaksi',
                "Pelanggan sudah melakukan <br> Pembayaran di bulan <b>{$months[$bulan]}</b> {$tahun}"
            );
            redirect('user/Belum_Lunas/C_Pembayaran_Perbulan/Payment/' . $post['id_customer']);
            return;
        }

        // Dapatkan nama penagih dari login
        $loginData = $this->M_AkunPenagihan->CheckLogin($email);
        $nama_penagih = $loginData->nama_penagih ?? 'Unknown';

        // Data pembayaran
        $paymentData = [
            'order_id'         => $post['order_id'],
            'gross_amount'     => $post['gross_amount'],
            'name_pppoe'       => $post['name_pppoe'],
            'nama_paket'       => $post['nama_paket'],
            'nama_admin'       => $nama_penagih,
            'keterangan'       => $post['keterangan'],
            'transaction_time' => $post['transaction_time'],
            'expired_date'     => $post['transaction_time'],
            'status_code'      => 200,
        ];

        $dataPelanggan = [
            'disabled'         => 'false',
        ];

        if ($post['disabled'] == 'true') {
            // Koneksi Mikrotik
            $connectors = [
                'Kraksaan' => 'Connect_Kraksaaan',
                'Paiton'   => 'Connect_Paiton',
            ];

            if (isset($connectors[$cluster])) {
                $connectFunc = $connectors[$cluster];
                if (function_exists($connectFunc)) {
                    $api = $connectFunc();
                }
            }

            if (isset($api)) {
                $api->comm('/ppp/secret/set', [
                    '.id'      => $post['id_pppoe'],
                    'disabled' => 'false',
                ]);
                $api->disconnect();
            }
        }

        // Simpan data ke dua tabel
        $this->M_CRUD->insertData($paymentData, 'data_pembayaran');
        $this->M_CRUD->insertData($paymentData, 'data_pembayaran_history');

        // Update ke database (dua tabel)
        $this->M_CRUD->updateData('data_customer', $dataPelanggan, ['id_customer' => $post['id_customer']]);

        // Notifikasi sukses
        $this->session->set_flashdata(
            'success_transaksi',
            "Pembayaran Pelanggan <b>{$post['nama_customer']}</b> Berhasil <br> Di bulan <b>{$months[$bulan]}</b> {$tahun}"
        );

        redirect('user/Belum_Lunas/C_Belum_Lunas');
    }
}
