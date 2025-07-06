<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_OOS_Pelanggan extends CI_Controller
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
        $session = $this->session;

        $cluster       = $session->userdata('cluster');

        $data['Jumlah_OOS_All']    = $this->M_OOS_Pelanggan->Jumlah_OOS_All($cluster);
        $data['Jumlah_OOS_Today']    = $this->M_OOS_Pelanggan->Jumlah_OOS_Today($cluster);
        $data['Jumlah_OOS_LastWeek'] = $this->M_OOS_Pelanggan->Jumlah_OOS_Lastweek($cluster);
        $data['Jumlah_OOS_OneMonth'] = $this->M_OOS_Pelanggan->Jumlah_OOS_OneMonth($cluster);

        $this->load->view('template/admin/V_Header_New');
        $this->load->view('template/admin/V_Sidebar_New');
        $this->load->view('template/admin/V_Get_OOS');
        $this->load->view('admin/OOS_Pelanggan/V_OOS_Pelanggan', $data);
        $this->load->view('template/admin/V_Footer_New');
    }

    public function GetDataAjax()
    {
        $session = $this->session;

        $cluster       = $session->userdata('cluster');

        $result = $this->M_OOS_Pelanggan->OOS_Today($cluster);

        $no = 0;

        foreach ($result as $dataCustomer) {

            $lastLoggedOut = $dataCustomer['last_logged_out'];
            $displayDate = ($lastLoggedOut && $lastLoggedOut !== '0000-00-00 00:00:00')
                ? date('d-m-Y / H:i:s', strtotime($lastLoggedOut))
                : '-';

            $status = strtoupper(trim($dataCustomer['status'] ?? ''));

            $isDown = $status === 'DOWN';

            $Status_OOS = $isDown
                ? '<span class="badge bg-danger px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">DOWN</span>'
                : '<span class="badge bg-success px-2 py-1" style="font-size: 0.65rem; border-radius: 999px;">UP</span>';

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . strtoupper($dataCustomer['tiket_id']) . '</div>';
            $row[] = '<div class="text-center">' . ucwords(strtolower($dataCustomer['nama_customer'])) . '</div>';
            $row[] = '<div class="text-center">' . strtoupper($dataCustomer['name_pppoe']) . '</div>';
            $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_paket']) . '</div>';
            $row[] = '<div class="text-center">' . $displayDate . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['jumlah_gangguan'] . '</div>';
            $row[] = '<div class="text-center">' . $Status_OOS . '</div>';

            $data[] = $row;
        }

        $ouput = array(
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }
}
