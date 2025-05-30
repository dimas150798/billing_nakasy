<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_FormLogin extends CI_Controller
{

    public function index()
    {
        // Validasi form input
        $this->form_validation->set_rules('email_login', 'Email', 'required', ['required' => 'Masukkan data terlebih dahulu']);
        $this->form_validation->set_rules('password_login', 'Password', 'required', ['required' => 'Masukkan data terlebih dahulu']);

        if ($this->form_validation->run() === false) {
            // Jika validasi gagal, kembali ke halaman login
            $this->load->view('V_FormLogin');
            return;
        }

        // Ambil data input dari form
        $email_login    = $this->input->post('email_login');
        $password_login = $this->input->post('password_login');

        // Cek kredensial pengguna di database
        $checkDataLogin = $this->M_Login->CheckLogin($email_login, $password_login);

        // Jika data tidak ditemukan
        if (!$checkDataLogin) {
            $this->session->set_flashdata('login_error', 'Email atau password salah!');
            redirect('C_FormLogin');
            return;
        }

        // Jika email cocok dan akses valid
        if ($email_login === $checkDataLogin->email_login) {

            // Username dari email (huruf kapital awal)
            $Username_Email = ucfirst(strstr($checkDataLogin->email_login, '@', true));

            // Set session data
            $this->session->set_userdata([
                'email'           => $checkDataLogin->email_login,
                'cluster'         => $checkDataLogin->cluster,
                'role'            => $checkDataLogin->nama_akses,
                'username_email'  => $Username_Email
            ]);

            // Redirect sesuai akses
            switch ($checkDataLogin->id_akses) {
                case 1:
                    redirect('superadmin/C_Dashboard_Superadmin');
                    break;
                case 2:
                    redirect('admin/C_Dashboard_Admin');
                    break;
                case 3:
                    redirect('user/C_Dashboard_User');
                    break;
                default:
                    // Akses tidak dikenali
                    $this->session->set_flashdata('login_error', 'Akses tidak dikenali!');
                    redirect('C_FormLogin');
                    break;
            }
        } else {
            // Jika email tidak cocok
            $this->session->set_flashdata('login_error', 'Email atau password salah!');
            redirect('C_FormLogin');
        }
    }


    public function TerminasiAuto()
    {
        date_default_timezone_set("Asia/Jakarta");
        // Menampilkan tanggal sekarang
        $toDay = date('Y-m-d');

        // Memisahkan Tanggal
        $pecahDay   = explode("-", $toDay);

        $tahun      = $pecahDay[0];
        $bulan      = $pecahDay[1];
        $tanggal    = $pecahDay[2];

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $data['dataTerminasi'] = $this->MikrotikModel->TerminasiAuto($bulan, $tahun, $TanggalAkhir, $tanggal);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // $this->load->view('template/header', $data);
        // $this->load->view('V_TerminasiAuto', $data);
        // $this->load->view('template/V_FooterTerminasiAuto', $data);
    }

    public function GetTerminasiAuto()
    {
        date_default_timezone_set("Asia/Jakarta");
        $toDay = date('Y-m-d');

        // Memisahkan Tanggal
        $pecahDay = explode("-", $toDay);

        $tahun = $pecahDay[0];
        $bulan = $pecahDay[1];
        $tanggal = $pecahDay[2];

        // Menampilkan tanggal pada awal bulan
        $tanggal_awal = date("01");
        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        // Menggabungkan bulan dan tahun
        $TanggalAwal = $tahun . '-' . $bulan . '-' . $tanggal_awal;
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $result = $this->MikrotikModel->TerminasiAuto($bulan, $tahun, $TanggalAkhir);

        $no = 0;

        foreach ($result as $dataCustomer) {
            $GrossAmount = $dataCustomer['gross_amount'] == NULL;

            $row = array();
            $row[] = ++$no;
            $row[] = $dataCustomer['name'];
            $row[] = '<div class="text-center">' . ($GrossAmount ? 'Penagihan Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['nama_paket'] . '</div>';
            $row[] = '<div class="text-center">' . 'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '</div>';
            $row[] = '<div class="text-center">' . ($GrossAmount ? '<span class="badge bg-danger">BELUM LUNAS</span>' : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';

            $data[] = $row;
        }

        $ouput = array(
            'data' => $data,
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }

    public function InsertCustomer()
    {
        $this->MikrotikModel->index();
    }

    public function logout()
    {
        session_start();
        session_destroy();

        redirect('C_FormLogin');
    }
}
