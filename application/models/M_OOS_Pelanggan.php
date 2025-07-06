<?php

class M_OOS_Pelanggan extends CI_Model
{

    // Menampilkan Pelanggan Gangguan
    public function OOS_Today($cluster)
    {
        $query = $this->db->query("SELECT 
            dgc.id_gangguan, dgc.tiket_id, dgc.name_pppoe, dgc.last_logged_out, dgc.up_time,
            dgc.last_caller_id, dgc.last_disconnect_reason, dgc.jumlah_gangguan, dgc.status, 
            dgc.kode_mikrotik,
            dc.nama_paket, dc.deskripsi_customer, dc.nama_customer

        FROM data_gangguan_customer AS dgc
        LEFT JOIN data_customer AS dc ON dgc.name_pppoe = dc.name_pppoe

        WHERE dgc.kode_mikrotik = '$cluster'
        
        ORDER BY dgc.last_logged_out DESC");

        return $query->result_array();
    }


    // Menampilkan Pelanggan Gangguan
    public function Jumlah_OOS_All($cluster)
    {
        $query = $this->db->query("SELECT 
        dgc.id_gangguan, dgc.tiket_id, dgc.name_pppoe, dgc.last_logged_out, dgc.up_time,
        dgc.last_caller_id, dgc.last_disconnect_reason, dgc.jumlah_gangguan, dgc.status, 
        dgc.kode_mikrotik,
        dc.nama_paket, dc.deskripsi_customer, dc.nama_customer

        FROM data_gangguan_customer AS dgc
        LEFT JOIN data_customer AS dc ON dgc.name_pppoe = dc.name_pppoe

        WHERE dgc.kode_mikrotik = '$cluster' AND dgc.status = 'DOWN'

        ORDER BY dgc.last_logged_out DESC");

        return $query->num_rows();
    }

    // Menampilkan Pelanggan Gangguan
    public function Jumlah_OOS_Today($cluster)
    {
        $query = $this->db->query("SELECT 
        dgc.id_gangguan, dgc.tiket_id, dgc.name_pppoe, dgc.last_logged_out, dgc.up_time,
        dgc.last_caller_id, dgc.last_disconnect_reason, dgc.jumlah_gangguan, dgc.status, 
        dgc.kode_mikrotik,
        dc.nama_paket, dc.deskripsi_customer, dc.nama_customer

        FROM data_gangguan_customer AS dgc
        LEFT JOIN data_customer AS dc ON dgc.name_pppoe = dc.name_pppoe

        WHERE dgc.kode_mikrotik = '$cluster' AND dgc.status = 'DOWN'
        AND DATE(dgc.last_logged_out) = CURDATE()

        ORDER BY dgc.last_logged_out DESC");

        return $query->num_rows();
    }

    public function Jumlah_OOS_Lastweek($cluster)
    {
        $query = $this->db->query("SELECT 
        dgc.id_gangguan, dgc.tiket_id, dgc.name_pppoe, dgc.last_logged_out, dgc.up_time,
        dgc.last_caller_id, dgc.last_disconnect_reason, dgc.jumlah_gangguan, dgc.status, 
        dgc.kode_mikrotik,
        dc.nama_paket, dc.deskripsi_customer, dc.nama_customer

        FROM data_gangguan_customer AS dgc
        LEFT JOIN data_customer AS dc ON dgc.name_pppoe = dc.name_pppoe

        WHERE dgc.kode_mikrotik = '$cluster' AND dgc.status = 'DOWN'
        AND DATE(dgc.last_logged_out) BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()

        ORDER BY dgc.last_logged_out DESC");

        return $query->num_rows();
    }

    public function Jumlah_OOS_OneMonth($cluster)
    {
        $query = $this->db->query("SELECT 
        dgc.id_gangguan, dgc.tiket_id, dgc.name_pppoe, dgc.last_logged_out, dgc.up_time,
        dgc.last_caller_id, dgc.last_disconnect_reason, dgc.jumlah_gangguan, dgc.status, 
        dgc.kode_mikrotik,
        dc.nama_paket, dc.deskripsi_customer, dc.nama_customer

        FROM data_gangguan_customer AS dgc
        LEFT JOIN data_customer AS dc ON dgc.name_pppoe = dc.name_pppoe

        WHERE dgc.kode_mikrotik = '$cluster' AND dgc.status = 'DOWN'
        AND DATE(dgc.last_logged_out) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()

        ORDER BY dgc.last_logged_out DESC", [$cluster]);

        return $query->num_rows();
    }
}
