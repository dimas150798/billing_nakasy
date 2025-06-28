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
        $cluster = $this->session->userdata('cluster');
        $data['Jumlah_SudahLunas'] = $this->M_SudahLunas->JumlahSudahLunas($month, $year, $lastDate, $cluster);

        $get_nominal = $this->M_SudahLunas->NominalSudahLunas($month, $year, $lastDate, $cluster);
        $data['Nominal_SudahLunas'] = $get_nominal->total_transaksi ?? 0;

        // Load tampilan
        $this->load->view('template/admin/V_Header_New');
        $this->load->view('template/admin/V_Get_SudahLunas');
        $this->load->view('template/admin/V_Sidebar_New');
        $this->load->view('admin/Sudah_Lunas/V_Sudah_Lunas', $data);
        $this->load->view('template/admin/V_Footer_New');
    }

    public function GetDataAjax()
    {
        $session = $this->session;

        $bulan         = $session->userdata('bulanGET') ?? $session->userdata('bulan');
        $tahun         = $session->userdata('tahunGET') ?? $session->userdata('tahun');
        $tanggalAkhir  = $session->userdata('TanggalAkhirGET') ?? $session->userdata('TanggalAkhir');
        $cluster       = $session->userdata('cluster');

        $result = $this->M_SudahLunas->SudahLunas($bulan, $tahun, $tanggalAkhir, $cluster);

        $data = [];
        $no = 1;

        if (!empty($result)) {
            foreach ($result as $customer) {
                $isDisabled = $customer['disabled'] === 'true';
                $isBelumBayar = is_null($customer['created_at']) || $customer['created_at'] == '';

                $tanggalInfo = $isBelumBayar
                    ? date('d-m-Y / H:i:s', strtotime($customer['transaction_time']))
                    : date('d-m-Y / H:i:s', strtotime($customer['created_at']));

                $Status_Mikrotik = $isDisabled
                    ? '<span class="badge bg-danger px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">DISABLE</span>'
                    : '<span class="badge bg-success px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">ENABLE</span>';

                $data[] = [
                    '<div class="text-center">' . $no++ . '</div>',
                    '<div class="text-center">' . ucwords(strtolower($customer['nama_customer'])) . '</div>',
                    '<div class="text-center">' . $customer['name_pppoe'] . '</div>',
                    '<div class="text-center">' . $tanggalInfo . '</div>',
                    '<div class="text-center">' . $customer['nama_paket'] . '</div>',
                    '<div class="text-center">' . number_format($customer['gross_amount'], 0, ',', '.') . '</div>',
                    '<div class="text-center">' . ucwords(strtolower($customer['nama_admin'])) . '</div>',
                    '<div class="text-center keterangan-col">' . ucwords(strtolower($customer['keterangan'])) . '</div>',

                    '<div class="text-center">' . $Status_Mikrotik . '</div>',

                    '<div class="text-center">
                        <div class="d-flex justify-content-center align-items-center flex-nowrap gap-1">
                            <button onclick="WA_Data(\'' . $customer['order_id'] . '\')" class="btn btn-sm btn-outline-success rounded-pill px-2" title="Kirim via WA">
                                <i class="bi bi-whatsapp"></i>
                            </button>
                            <button onclick="Kwitansi(\'' . $customer['order_id'] . '\')" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Kwitansi">
                                <i class="bi bi-printer"></i>
                            </button>
                            <button onclick="Edit_Data(\'' . $customer['order_id'] . '\')" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Edit Data">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button onclick="Delete_Data(\'' . $customer['order_id'] . '\')" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus Data">
                                <i class="bi bi-trash"></i>
                            </button>
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
