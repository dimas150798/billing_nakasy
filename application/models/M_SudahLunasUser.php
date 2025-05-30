<?php

class M_SudahLunasUser extends CI_Model
{

    // Menampilkan Data Sudah Lunas
    public function SudahLunas($bulan, $tahun, $tanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih)
    {
        $query   = $this->db->query("SELECT 
        data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
        data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, data_customer.disabled, 
        DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket

        FROM data_customer
        LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe

        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NOT NULL AND
        data_customer.nama_area in ('$area_1', '$area_2', '$area_3', '$area_4', '$area_5') AND
        data_pembayaran.nama_admin = '$nama_penagih'

        GROUP BY data_customer.name_pppoe
        ORDER BY data_pembayaran.order_id DESC");

        return $query->result_array();
    }

    // Menampilkan Jumlah Belum Lunas
    public function JumlahSudahLunas($bulan, $tahun, $tanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih)
    {
        $query   = $this->db->query("SELECT 
        data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
        data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
        DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket

        FROM data_customer
        LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NOT NULL AND
        data_customer.nama_area in ('$area_1', '$area_2', '$area_3', '$area_4', '$area_5') AND
        data_pembayaran.nama_admin = '$nama_penagih'

        GROUP BY data_customer.name_pppoe
        ORDER BY DAY(data_customer.start_date) ASC");

        return $query->num_rows();
    }

    // Menampilkan Jumlah Nominal Belum Lunas
    public function NominalSudahLunas($bulan, $tahun, $tanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih)
    {
        $result   = $this->db->query("SELECT 
        SUM(data_pembayaran.gross_amount) AS hargaPaket

        FROM data_customer 
        LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
        
        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir'
        AND data_pembayaran.transaction_time IS NOT NULL AND  data_customer.stop_date IS NULL AND
        data_customer.nama_area in ('$area_1', '$area_2', '$area_3', '$area_4', '$area_5') AND
        data_pembayaran.nama_admin = '$nama_penagih'
        
        ");

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Menampilkan Jumlah Biaya Admin
    public function NominalBiayaAdmin($bulan, $tahun, $tanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih)
    {
        $result   = $this->db->query("SELECT 
            SUM(data_pembayaran.biaya_admin) AS biayaAdmin
    
            FROM data_customer 
            LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
            LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
            AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
            
            WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir'
            AND data_pembayaran.transaction_time IS NOT NULL AND  data_customer.stop_date IS NULL AND
            data_customer.nama_area in ('$area_1', '$area_2', '$area_3', '$area_4', '$area_5') AND
            data_pembayaran.nama_admin = '$nama_penagih'
        
        ");

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Invoice payment
    public function invoice()
    {
        $sql = "SELECT MAX(MID(order_id,8,4)) AS invoiceID 
        FROM data_pembayaran
        WHERE MID(order_id,4,4) = DATE_FORMAT(CURDATE(), '%y%m')";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $dataRow    = $query->row();
            $dataN      = ((int)$dataRow->invoiceID) + 1;
            $no         = sprintf("%'.04d", $dataN);
        } else {
            $no         = "0001";
        }

        $invoice = "INT" . date('ym') . $no;
        return $invoice;
    }

    // Pembayaran Pelanggan
    public function Payment($id_customer)
    {
        $query   = $this->db->query("SELECT 
            data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
            data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
            DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales,
            data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
            data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
            data_pembayaran.bank, data_pembayaran.va_number, data_p embayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
            data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket,
            MONTH(data_pembayaran.transaction_time) as bulan_payment
            FROM data_customer
            LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
            LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe

            WHERE data_customer.id_customer = '$id_customer'
    
            GROUP BY data_customer.name_pppoe
            ORDER BY DAY(data_customer.start_date) ASC");

        return $query->result_array();
    }
}
