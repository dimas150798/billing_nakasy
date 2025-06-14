<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Sudah_Lunas extends CI_Controller
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

        // Untuk ditampilkan (tanpa 0 di depan bulan)
        $bulan_show = $this->session->userdata('bulan_GET') ?? date("n");
        $tahun_show = $this->session->userdata('tahunGET') ?? date("Y");

        // Query data
        $checkLogin                 = $this->M_AkunPenagihan->CheckLogin($this->session->userdata('email'));

        $area_1                     = $checkLogin->area_1;
        $area_2                     = $checkLogin->area_2;
        $area_3                     = $checkLogin->area_3;
        $area_4                     = $checkLogin->area_4;
        $area_5                     = $checkLogin->area_5;

        // nama penagih
        $nama_penagih               = $checkLogin->nama_penagih;
        $NominalTagihan             = $this->M_SudahLunasUser->NominalSudahLunas($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
        $NominalFee                 = $this->M_SudahLunasUser->NominalBiayaAdmin($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
        $Jumlah_Pelanggan           = $this->M_SudahLunasUser->JumlahSudahLunas($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);


        $data['Jumlah_SudahLunas']  = $this->M_SudahLunasUser->JumlahSudahLunas($month, $year, $lastDate, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
        $data['Nominal_Tagihan']    = $NominalTagihan->hargaPaket;
        $data['Nominal_Fee']        = $Jumlah_Pelanggan * 3000;
        $data['Total_Akhir']        = $NominalTagihan->hargaPaket - $Jumlah_Pelanggan * 3000;

        // Load tampilan
        $this->load->view('template/user/V_Header');
        $this->load->view('template/user/V_Sidebar');
        $this->load->view('template/user/V_Get_SudahLunas');
        $this->load->view('user/Sudah_Lunas/V_Sudah_Lunas', $data);
        $this->load->view('template/user/V_Footer');
    }

    public function GetDataAjax()
    {
        $session = $this->session;

        $bulan         = $session->userdata('bulanGET') ?? $session->userdata('bulan');
        $tahun         = $session->userdata('tahunGET') ?? $session->userdata('tahun');
        $tanggalAkhir  = $session->userdata('TanggalAkhirGET') ?? $session->userdata('TanggalAkhir');
        $cluster       = $session->userdata('cluster');

        // Mengambil data area
        $checkLogin                 = $this->M_AkunPenagihan->CheckLogin($this->session->userdata('email'));

        $area_1                     = $checkLogin->area_1;
        $area_2                     = $checkLogin->area_2;
        $area_3                     = $checkLogin->area_3;
        $area_4                     = $checkLogin->area_4;
        $area_5                     = $checkLogin->area_5;

        // nama penagih
        $nama_penagih               = $checkLogin->nama_penagih;

        $result                     = $this->M_SudahLunasUser->SudahLunas($bulan, $tahun, $tanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);

        $data = [];
        $no = 1;

        if (!empty($result)) {
            foreach ($result as $customer) {
                $isBelumBayar = is_null($customer['gross_amount']);
                $isDisabled = $customer['disabled'] === 'true';

                $tanggalInfo = $isBelumBayar
                    ? 'Penagihan Tanggal ' . $customer['tanggal']
                    : date('d-m-Y / H:i:s', strtotime($customer['transaction_time']));

                $Status_Mikrotik = $isDisabled
                    ? '<span class="badge bg-danger">DISABLE</span>'
                    : '<span class="badge bg-success">ENABLE</span>';

                $data[] = [
                    '<div class="text-center">' . $no++ . '</div>',
                    '<div class="text-center">' . ucwords(strtolower($customer['nama_customer'])) . '</div>',
                    '<div class="text-center">' . $customer['name_pppoe'] . '</div>',
                    '<div class="text-center">' . $tanggalInfo . '</div>',
                    '<div class="text-center">' . $customer['nama_paket'] . '</div>',
                    '<div class="text-center">' . number_format($customer['gross_amount'], 0, ',', '.') . '</div>',
                    '<div class="text-center">' . ucwords(strtolower($customer['nama_admin'])) . '</div>',
                    '<div class="text-center">' . $Status_Mikrotik . '</div>',

                    '<div class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu shadow-sm rounded-3">
                            <li><a onclick="WA_Data(\'' . $customer['order_id'] . '\')" class="dropdown-item text-black"><i class="bi bi-whatsapp text-success"></i> Kirim by WA</a></li>
                        </ul>
                    </div>

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
