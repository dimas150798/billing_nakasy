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

        // Untuk ditampilkan (tanpa 0 di depan bulan)
        $bulan_show = $this->session->userdata('bulan_GET') ?? date("n");
        $tahun_show = $this->session->userdata('tahunGET') ?? date("Y");

        // Query data
        $cluster = $this->session->userdata('cluster');
        $data['Jumlah_BelumLunas'] = $this->M_BelumLunas->JumlahBelumLunas($month, $year, $lastDate, $cluster);

        $getPaket = $this->M_BelumLunas->NominalBelumLunas($month, $year, $lastDate, $cluster);
        $data['Nominal_BelumLunas'] = $getPaket->hargaPaket ?? 0;

        // Load tampilan
        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('template/admin/V_Get_BelumLunas');
        $this->load->view('admin/Belum_Lunas/V_Belum_Lunas', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function GetDataAjax()
    {
        $session = $this->session;

        $bulan         = $session->userdata('bulanGET') ?? $session->userdata('bulan');
        $tahun         = $session->userdata('tahunGET') ?? $session->userdata('tahun');
        $tanggalAkhir  = $session->userdata('TanggalAkhirGET') ?? $session->userdata('TanggalAkhir');
        $cluster       = $session->userdata('cluster');

        $result = $this->M_BelumLunas->BelumLunas($bulan, $tahun, $tanggalAkhir, $cluster);

        $data = [];
        $no = 1;

        if (!empty($result)) {
            foreach ($result as $customer) {
                $isDisabled = $customer['disabled'] === 'true';

                $Status_Mikrotik = $isDisabled
                    ? '<span class="badge bg-danger">DISABLE</span>'
                    : '<span class="badge bg-success">ENABLE</span>';

                $data[] = [
                    '<div class="text-center">' . $no++ . '</div>',
                    '<div class="text-center">' . ucwords(strtolower($customer['nama_customer'])) . '</div>',
                    '<div class="text-center">' . $customer['name_pppoe'] . '</div>',
                    '<div class="text-center">' . $customer['nama_paket'] . '</div>',
                    '<div class="text-center">' . number_format($customer['harga_paket'], 0, ',', '.') . '</div>',
                    '<div class="text-center">' . $Status_Mikrotik . '</div>',

                    '<div class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu shadow-sm rounded-3">
                            <li><a onclick="WA_Data(' . $customer['id_customer'] . ')" class="dropdown-item text-black"><i class="bi bi-whatsapp text-success"></i> Kirim by WA</a></li>
                            <li><a onclick="Pembayaran(' . $customer['id_customer'] . ')" class="dropdown-item text-black"><i class="bi bi-credit-card"></i> Pembayaran</a></li>
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
