<?php

class M_Rekening extends CI_Model
{
    // Menampilkan Data Rekening
    public function DataRekening()
    {
        $query   = $this->db->query("SELECT id_rekening, nama_bank, no_rekening, nama_rekening, daerah_rekening
                FROM data_rekening
                GROUP BY daerah_rekening
                ORDER BY daerah_rekening ASC");

        return $query->result_array();
    }

    // Edit Paket
    public function EditRekening($id_rekening)
    {
        $query   = $this->db->query("SELECT id_rekening, nama_bank, no_rekening, nama_rekening, daerah_rekening
        FROM data_rekening

        WHERE id_rekening = '$id_rekening'
        ORDER BY daerah_rekening ASC");

        return $query->result_array();
    }

    // Check data paket
    public function CheckRekening($daerah_rekening)
    {
        $query = $this->db->query("SELECT id_rekening, nama_bank, no_rekening, nama_rekening, daerah_rekening
        FROM data_rekening

        WHERE daerah_rekening = '$daerah_rekening'");

        return $query->result_array();
    }
}
