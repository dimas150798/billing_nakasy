<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Terminasi_Kraksaan extends CI_Controller
{

    public function index()
    {
        // Data jabatan
        $data_jabatan = [
            'nama_jabatan' => 'Test',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        // Simpan data ke tabel 'data_jabatan'
        $this->M_CRUD->insertData($data_jabatan, 'data_jabatan');
    }

    public function Terminasi()
    {
        // Data jabatan
        $data_jabatan = [
            'nama_jabatan' => 'Test',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        // Simpan data ke tabel 'data_jabatan'
        $this->M_CRUD->insertData($data_jabatan, 'data_jabatan');
    }
}
