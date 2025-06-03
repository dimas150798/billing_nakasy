<?php

class M_AkunPenagihan extends CI_Model
{

    // Menampilkan Data Penagih
    public function DataPenagih()
    {
        $query   = $this->db->query("SELECT id_penagih, email_login, nama_penagih, area_1, area_2, area_3, area_4, area_5
            FROM data_penagih

            ORDER BY email_login ASC");

        return $query->result_array();
    }

    // Menampilkan Data Login User
    public function DataLoginUser()
    {
        $query   = $this->db->query("SELECT data_login.id_login, data_login.email_login, data_login.password_login, 
                data_login.id_akses, data_akses.nama_akses
                FROM data_login
    
                LEFT JOIN data_akses ON data_login.id_akses = data_akses.id_akses

                WHERE data_login.id_akses = 3
                ORDER BY data_login.id_login ASC");

        return $query->result_array();
    }

    // Edit Data Login
    public function EditPenagihan($id_penagih)
    {
        $query   = $this->db->query("SELECT id_penagih, email_login, nama_penagih, area_1, area_2, area_3, area_4, area_5
        FROM data_penagih

        WHERE id_penagih = '$id_penagih'

        ORDER BY email_login ASC");

        return $query->result_array();
    }

    // Check akses login
    public function CheckLogin($email_login)
    {
        $this->db->select('id_penagih, nama_penagih, email_login, area_1, area_2, area_3, area_4, area_5');
        $this->db->where('email_login', $email_login);

        $this->db->limit(1);
        $result = $this->db->get('data_penagih');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Check data akun penagihan
    public function CheckDuplicateEmail($email_login)
    {
        $this->db->select('id_penagih, nama_penagih, email_login, area_1, area_2, area_3, area_4, area_5');
        $this->db->where('email_login', $email_login);

        $this->db->limit(1);
        $result = $this->db->get('data_penagih');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
