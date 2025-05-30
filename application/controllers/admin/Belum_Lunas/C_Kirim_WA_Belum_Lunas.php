<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Kirim_WA_Belum_Lunas extends CI_Controller
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

    public function KirimWA_BelumLunas($id_customer)
    {
        // Ambil bulan dan tahun dari session
        $bulan = $this->session->userdata('bulanGET') ?: $this->session->userdata('bulan');
        $tahun = $this->session->userdata('tahunGET') ?: $this->session->userdata('tahun');

        // Ambil data pelanggan dari model
        $data['Data_Pelanggan'] = $this->M_BelumLunas->Payment($id_customer);
        $data['Data_Rekening']   = $this->M_Rekening->DataRekening();

        // Load tampilan
        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_BelumLunas');
        $this->load->view('admin/Belum_Lunas/V_Kirim_WA_Belum_Lunas', $data);
        $this->load->view('template/admin/V_Footer');
    }


    public function KirimWA_Aksi()
    {
        //mengambil data post pada view 
        $kode_customer          = $this->input->post('kode_customer');
        $nama_customer          = $this->input->post('nama_customer');
        $bulan_pembayaran       = $this->input->post('bulan_pembayaran');
        $phone_customer         = $this->input->post('phone_customer');
        $nama_paket             = $this->input->post('nama_paket');
        $harga_paket            = $this->input->post('harga_paket');
        $daerah_rekening        = $this->session->userdata('cluster');

        $GetDataRekening        = $this->M_Rekening->CheckRekening($daerah_rekening);

        // Rekening 1
        $nama_bank_1            = $GetDataRekening[0]['nama_bank'];
        $no_rekening_1          = $GetDataRekening[0]['no_rekening'];
        $nama_rekening_1        = $GetDataRekening[0]['nama_rekening'];

        // Rekening 2
        $nama_bank_2            = $GetDataRekening[1]['nama_bank'];
        $no_rekening_2          = $GetDataRekening[1]['no_rekening'];
        $nama_rekening_2        = $GetDataRekening[1]['nama_rekening'];

        $convertPhone = preg_replace('/^\+?08/', '628', $phone_customer);

        header("location:https://api.whatsapp.com/send?phone=$convertPhone&text=*NAKASY* %0a%0a Yth Bapak / Ibu %0a Nama : $nama_customer %0a Telepon : $phone_customer %0a%0a *PEMBAYARAN* %0a Tagihan Bulan : $bulan_pembayaran %0a Jenis Paket : $nama_paket %0a Harga Paket : $harga_paket %0a Total : $harga_paket (Sudah Termasuk PPN) %0a%0a Keterangan : *Belum Terbayar* %0a%0a *Informasi Tambahan* %0a Pembayaran dapat dilakukan dengan cara : %0a%0a *Transfer BANK* %0a Nomor rekening $no_rekening_1 Bank $nama_bank_1 atas nama *$nama_rekening_1* %0a%0a Atau *Transfer BANK* %0a Nomor rekening $no_rekening_2 Bank $nama_bank_2 atas nama *$nama_rekening_2* %0a%0a Selesai melakukan pembayaran Mohon dapat *dilampirkan bukti pembayaran* pada balasan pesan ini %0a%0a Jika ada pertanyaan lebih lanjut, anda dapat langsung membalas pesan ini. %0a%0a Terima Kasih. %0a Hormat Kami. %0a%0a *NAKASY*
            ");

        echo "
        <script>
            window.location=history.go(-1);
        </script>
        ";
    }
}
