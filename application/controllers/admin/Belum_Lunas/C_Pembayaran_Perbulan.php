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
            // 'disabled'         => 'false',
            'status_code'      => 200
        ];

        $cluster = $this->session->userdata('cluster');

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

        if ($api) {
            $api->comm('/ppp/secret/set', [
                '.id'      => $post['id_pppoe'],
                'disabled' => 'false',
            ]);
            $api->disconnect();
        }

        // Simpan ke database (dua tabel)
        $this->M_CRUD->insertData($paymentData, 'data_pembayaran');
        $this->M_CRUD->insertData($paymentData, 'data_pembayaran_history');

        redirect('admin/Belum_Lunas/C_Belum_Lunas');
    }

    // public function PaymentSave1()
    // {
    //     // Mengambil data post pada view
    //     $id_pppoe               = $this->input->post('id_pppoe');
    //     $id_customer            = $this->input->post('id_customer');
    //     $order_id               = $this->input->post('order_id');
    //     $gross_amount           = $this->input->post('gross_amount');
    //     $nama_customer          = $this->input->post('nama_customer');
    //     $name_pppoe             = $this->input->post('name_pppoe');
    //     $nama_paket             = $this->input->post('nama_paket');
    //     $transaction_time       = $this->input->post('transaction_time');
    //     $biaya_admin            = $this->input->post('biaya_admin');
    //     $nama_admin             = $this->input->post('nama_admin');
    //     $keterangan             = $this->input->post('keterangan');

    //     $explode = explode("-", $transaction_time);
    //     echo $explode[0]; //untuk tahun
    //     echo $explode[1]; //untuk bulan
    //     echo $explode[2]; //untuk tanggal

    //     // Menyimpan data payment ke dalam array
    //     $dataPayment = array(
    //         'order_id'         => $order_id,
    //         'gross_amount'     => $gross_amount,
    //         'biaya_admin'      => $biaya_admin,
    //         'name_pppoe'       => $name_pppoe,
    //         'nama_paket'       => $nama_paket,
    //         'nama_admin'       => $nama_admin,
    //         'keterangan'       => $keterangan,
    //         'transaction_time' => $transaction_time,
    //         'expired_date'     => $transaction_time,
    //         'disabled'         => 'false',
    //         'status_code'      => 200
    //     );

    //     // Menyimpan data payment duplicate ke dalam array
    //     $dataPaymentDuplicate = array(
    //         'order_id'         => this->M_BelumLunas->invoice(),
    //         'gross_amount'     => $gross_amount,
    //         'biaya_admin'      => $biaya_admin,
    //         'name_pppoe'       => $name_pppoe,
    //         'nama_paket'       => $nama_paket,
    //         'nama_admin'       => $nama_admin,
    //         'keterangan'       => $keterangan,
    //         'transaction_time' => $transaction_time,
    //         'expired_date'     => $transaction_time,
    //         'disabled'         => 'false',
    //         'status_code'      => 200
    //     );

    //     // Memanggil mysql dari model
    //     $data['DataPelanggan']  = $this->M_BelumLunas->Payment($id_customer);

    //     $checkDuplicatePay      = $this->M_BelumLunas->CheckDuplicatePayment($explode[1], $explode[0], $name_pppoe);

    //     // Check Order Id
    //     $checkDuplicateCode = $this->M_BelumLunasUser->CheckDuplicateCode($order_id);

    //     // Rules form validation
    //     $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required');
    //     $this->form_validation->set_rules('transaction_time', 'Tanggal Transaksi', 'required');
    //     $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
    //     $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

    //     if ($this->form_validation->run() == false) {
    //         $this->load->view('template/header', $data);
    //         $this->load->view('template/sidebarAdmin', $data);
    //         $this->load->view('admin/BelumLunas/V_PayBelumLunas', $data);
    //         $this->load->view('template/V_FooterBelumLunas', $data);
    //     } else {
    //         if ($checkDuplicatePay->bulan_payment == $explode[1] && $checkDuplicatePay->tahun_payment == $explode[0] && $checkDuplicatePay->name_pppoe == $name_pppoe) {
    //             // Notifikasi duplicate payment
    //             $this->session->set_flashdata('DuplicatePay_icon', 'error');
    //             $this->session->set_flashdata('DuplicatePay_title', 'Payment Gagal');
    //             $this->session->set_flashdata('DuplicatePay_text', 'Customer sudah melakukan <br> Pembayaran bulan ini');

    //             echo "
    //             <script>history.go(-1);            
    //             </script>
    //             ";
    //         } else {
    //             if ($order_id != $checkDuplicateCode->order_id) {
    //                 // if ($kode_mikrotik = 'Kraksaan') {
    //                 //     $api = connectKraksaaan();
    //                 //     $api->comm('/ppp/secret/set', [
    //                 //         ".id" => $id_pppoe,
    //                 //         "disabled" => 'false',
    //                 //     ]);
    //                 //     $api->disconnect();
    //                 // }

    //                 // if ($kode_mikrotik_paiton = 'Paiton') {
    //                 //     $api = connectPaiton();
    //                 //     $api->comm('/ppp/secret/set', [
    //                 //         ".id" => $id_pppoe_paiton,
    //                 //         "disabled" => 'false',
    //                 //     ]);
    //                 //     $api->disconnect();
    //                 // }

    //                 $this->M_CRUD->insertData($dataPayment, 'data_pembayaran');
    //                 $this->M_CRUD->insertData($dataPayment, 'data_pembayaran_history');

    //                 // Notifikasi Login Berhasil
    //                 $this->session->set_flashdata('payment_icon', 'success');
    //                 $this->session->set_flashdata('payment_title', 'Pembayaran An. <b>' . $name_pppoe . '</b> Berhasil');

    //                 redirect('admin/BelumLunas/C_BelumLunas');
    //             } else {
    //                 // if ($kode_mikrotik = 'Kraksaan') {
    //                 //     $api = connectKraksaaan();
    //                 //     $api->comm('/ppp/secret/set', [
    //                 //         ".id" => $id_pppoe,
    //                 //         "disabled" => 'false',
    //                 //     ]);
    //                 //     $api->disconnect();
    //                 // }

    //                 // if ($kode_mikrotik_paiton = 'Paiton') {
    //                 //     $api = connectPaiton();
    //                 //     $api->comm('/ppp/secret/set', [
    //                 //         ".id" => $id_pppoe_paiton,
    //                 //         "disabled" => 'false',
    //                 //     ]);
    //                 //     $api->disconnect();
    //                 // }

    //                 $this->M_CRUD->insertData($dataPaymentDuplicate, 'data_pembayaran');
    //                 $this->M_CRUD->insertData($dataPaymentDuplicate, 'data_pembayaran_history');

    //                 // Notifikasi Login Berhasil
    //                 $this->session->set_flashdata('payment_icon', 'success');
    //                 $this->session->set_flashdata('payment_title', 'Pembayaran An. <b>' . $name_pppoe . '</b> Berhasil');

    //                 redirect('admin/BelumLunas/C_BelumLunas');
    //             }
    //         }
    //     }
    // }
}
