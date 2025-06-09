<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Kirim_WA_Lunas extends CI_Controller
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

    public function KirimWA_Lunas($order_id)
    {
        // Ambil bulan dan tahun dari session
        $bulan = $this->session->userdata('bulanGET') ?: $this->session->userdata('bulan');
        $tahun = $this->session->userdata('tahunGET') ?: $this->session->userdata('tahun');

        // Ambil data pelanggan dari model
        $data['Data_Pelanggan'] = $this->M_SudahLunas->Kirim_WA($order_id);

        // Load tampilan
        $this->load->view('template/user/V_Header');
        $this->load->view('template/user/V_Sidebar');
        $this->load->view('template/user/V_Get_SudahLunas');
        $this->load->view('user/Sudah_Lunas/V_Kirim_WA_Lunas', $data);
        $this->load->view('template/user/V_Footer');
    }


    public function KirimWA_Aksi()
    {
        //mengambil data post pada view 
        $kode_customer          = $this->input->post('kode_customer');
        $nama_paket             = $this->input->post('nama_paket');
        $harga_paket            = $this->input->post('harga_paket');
        $biaya_admin            = $this->input->post('biaya_admin');
        $total_transaksi        = $this->input->post('gross_amount');
        $nama_customer          = $this->input->post('nama_customer');
        $phone_customer         = $this->input->post('phone_customer');
        $bulan_transaksi        = $this->input->post('bulan_transaksi');

        $convertPhone = preg_replace('/^\+?08/', '628', $phone_customer);

        header("location:https://api.whatsapp.com/send?phone=$convertPhone&text=*NAKASY* %0a%0a Yth Bapak / Ibu %0a Nama : $nama_customer %0a ID Pelanggan : $kode_customer %0a Telepon : $phone_customer %0a%0a *PEMBAYARAN* %0a Tagihan Bulan : $bulan_transaksi %0a Jenis Paket : $nama_paket %0a Harga Paket : Rp.$harga_paket %0a Total : Rp.$total_transaksi (Sudah Termasuk PPN) %0a Keterangan : *Lunas* %0a%0a *Informasi Tambahan* %0a Simpan struk ini sebagai bukti telah melakukan pembayaran. %0a%0a Jika ada pertanyaan lebih lanjut, anda dapat langsung membalas pesan ini. %0a%0a Terima Kasih. %0a Hormat Kami. %0a%0a *NAKASY*
            ");

        echo "
        <script>
            window.location=history.go(-1);
        </script>
        ";
    }
}
