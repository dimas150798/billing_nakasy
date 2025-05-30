<?php

class M_Area extends CI_Model
{
    // Menampilkan Data Area
    public function DataArea()
    {
        $query   = $this->db->query("SELECT id_area, nama_area
                FROM data_area
                ORDER BY nama_area ASC");

        return $query->result_array();
    }
    public function EditArea($id_area)
    {
        $query   = $this->db->query("SELECT id_area, nama_area
        FROM data_area
        WHERE id_area = '$id_area'
        ORDER BY nama_area ASC");

        return $query->result_array();
    }

    // Check data area
    public function CheckDuplicateArea($nama_area)
    {
        $this->db->select('nama_area, id_area');
        $this->db->where('nama_area', $nama_area);

        $this->db->limit(1);
        $result = $this->db->get('data_area');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    public function Check_NamaArea($nama_area)
    {
        $this->db->select('nama_area, id_area');
        $this->db->where('nama_area', $nama_area);

        $this->db->limit(1);
        $result = $this->db->get('data_area');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
