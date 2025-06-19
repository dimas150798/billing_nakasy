<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Delete_Pelanggan extends CI_Controller
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

    public function Delete_Pelanggan($id_customer)
    {
        $cluster = $this->session->userdata('cluster');

        // Ambil data pelanggan berdasarkan ID
        $Check_Pelanggan = $this->M_Pelanggan->ID_Pelanggan($id_customer);

        // Jika tidak ditemukan, redirect dengan pesan error
        if (!$Check_Pelanggan) {
            $this->session->set_flashdata('registrasi_error', '❌ Pelanggan tidak ditemukan');
            redirect('admin/Data_Pelanggan/C_Data_Pelanggan');
            return;
        }

        // Hapus data di database
        $this->M_CRUD->deleteData(['id_customer' => $id_customer], 'data_customer');

        // Hubungkan ke API sesuai cluster
        $api = null;
        if ($cluster === 'Kraksaan') {
            $api = Connect_Kraksaaan();
        } elseif ($cluster === 'Paiton') {
            $api = Connect_Paiton();
        }

        // Cek koneksi API berhasil
        if ($api) {
            try {
                // Hapus PPP Secret jika ada ID-nya
                if (!empty($Check_Pelanggan->id_pppoe)) {
                    $api->comm('/ppp/secret/remove', [
                        '.id' => $Check_Pelanggan->id_pppoe,
                    ]);
                }
                $api->disconnect();
            } catch (Exception $e) {
                // Optional: log error jika perlu
            }
        }

        // Tampilkan pesan sukses
        $this->session->set_flashdata('registrasi_success', '✅ Delete Pelanggan Berhasil');
        redirect('admin/Data_Pelanggan/C_Data_Pelanggan');
    }
}
