<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Belum_Lunas extends CI_Controller
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
        date_default_timezone_set("Asia/Jakarta");

        // Cek apakah ada filter dari GET
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        if (!empty($bulan) && !empty($tahun)) {
            $bulanGET = sprintf("%02d", $bulan); // Format 2 digit
            $tanggalAkhir = cal_days_in_month(CAL_GREGORIAN, $bulanGET, $tahun);
            $tanggalAkhirFull = "$tahun-$bulanGET-$tanggalAkhir";

            // Simpan ke session
            $this->session->set_userdata([
                'bulan_GET'        => $bulan,
                'bulanGET'         => $bulanGET,
                'tahunGET'         => $tahun,
                'TanggalAkhirGET'  => $tanggalAkhirFull
            ]);
        } else {
            // Default (hari ini)
            $bulan = date("m");
            $tahun = date("Y");
            $tanggalAkhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $tanggalAkhirFull = "$tahun-$bulan-$tanggalAkhir";

            // Simpan ke session
            $this->session->set_userdata([
                'bulan'        => $bulan,
                'tahun'        => $tahun,
                'TanggalAkhir' => $tanggalAkhirFull
            ]);
        }

        // Ambil nilai dari session, gunakan default jika tidak tersedia
        $month      = $this->session->userdata('bulanGET') ?? $this->session->userdata('bulan');
        $year       = $this->session->userdata('tahunGET') ?? $this->session->userdata('tahun');
        $lastDate   = $this->session->userdata('TanggalAkhirGET') ?? $this->session->userdata('TanggalAkhir');

        $this->session->set_userdata([
            'Bulan_Opsi'        => $month,
            'Tahun_Opsi'        => $year
        ]);

        // Untuk ditampilkan (tanpa 0 di depan bulan)
        $bulan_show = $this->session->userdata('bulan_GET') ?? date("n");
        $tahun_show = $this->session->userdata('tahunGET') ?? date("Y");

        $checkLogin                 = $this->M_AkunPenagihan->CheckLogin($this->session->userdata('email'));

        $area_1                     = $checkLogin->area_1;
        $area_2                     = $checkLogin->area_2;
        $area_3                     = $checkLogin->area_3;
        $area_4                     = $checkLogin->area_4;
        $area_5                     = $checkLogin->area_5;

        // nama penagih
        $nama_penagih               = $checkLogin->nama_penagih;
        $Nominal_Tagihan            = $this->M_BelumLunasUser->NominalBelumLunas($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
        $Jumlah_Pelanggan           = $this->M_BelumLunasUser->JumlahBelumLunas($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
        $Nominal_Fee                = $Jumlah_Pelanggan * 3000;
        $Total_Akhir                = $Nominal_Tagihan->hargaPaket;


        $data['Jumlah_Pelanggan']   = $Jumlah_Pelanggan;
        $data['Nominal_Tagihan']    = $Nominal_Tagihan->hargaPaket;
        $data['Nominal_Fee']        = $Nominal_Fee;
        $data['Total_Akhir']        = $Total_Akhir;

        // Load tampilan
        $this->load->view('template/user/V_Header_New');
        $this->load->view('template/user/V_Sidebar_New');
        $this->load->view('template/user/V_Get_BelumLunas');
        $this->load->view('user/Belum_Lunas/V_Belum_Lunas', $data);
        $this->load->view('template/user/V_Footer_New');
    }

    public function GetDataAjax()
    {
        $session = $this->session;

        $bulan         = $session->userdata('bulanGET') ?? $session->userdata('bulan');
        $tahun         = $session->userdata('tahunGET') ?? $session->userdata('tahun');
        $tanggalAkhir  = $session->userdata('TanggalAkhirGET') ?? $session->userdata('TanggalAkhir');

        $checkLogin    = $this->M_AkunPenagihan->CheckLogin($this->session->userdata('email'));

        $area_1        = $checkLogin->area_1;
        $area_2        = $checkLogin->area_2;
        $area_3        = $checkLogin->area_3;
        $area_4        = $checkLogin->area_4;
        $area_5        = $checkLogin->area_5;

        $result        = $this->M_BelumLunasUser->BelumLunas($bulan, $tahun, $tanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5);

        $data = [];
        $no = 1;

        if (!empty($result)) {
            foreach ($result as $customer) {
                $isDisabled = $customer['disabled'] === 'true';

                $Status_Mikrotik = $isDisabled
                    ? '<span class="badge bg-danger px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">DISABLE</span>'
                    : '<span class="badge bg-success px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">ENABLE</span>';

                $data[] = [
                    '<div class="text-center">' . $no++ . '</div>',
                    '<div class="text-center">' . ucwords(strtolower($customer['nama_customer'])) . '</div>',
                    '<div class="text-center">' . $customer['name_pppoe'] . '</div>',
                    '<div class="text-center">' . $customer['nama_paket'] . '</div>',
                    '<div class="text-center">' . number_format($customer['harga_paket'], 0, ',', '.') . '</div>',
                    '<div class="text-center">' . $Status_Mikrotik . '</div>',

                    '<div class="text-center d-flex justify-content-center gap-2">
                        <button onclick="WA_Data(' . $customer['id_customer'] . ')" class="btn btn-sm btn-outline-success rounded-pill px-2" title="Kirim by WA">
                            <i class="bi bi-whatsapp"></i>
                        </button>
                        <button onclick="Pembayaran(' . $customer['id_customer'] . ')" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Pembayaran">
                            <i class="bi bi-credit-card"></i>
                        </button>
                    </div>'
                ];
            }
        }

        $output = ['data' => $data];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }
}
