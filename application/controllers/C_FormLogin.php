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

    public function logout()
    {
        session_start();
        session_destroy();

        redirect('C_FormLogin');
    }
}
