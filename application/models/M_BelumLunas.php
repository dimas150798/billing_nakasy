<?php

class M_BelumLunas extends CI_Model
{

    // Menampilkan Data Belum Lunas
    public function BelumLunas($bulan, $tahun, $tanggalAkhir, $cluster)
    {
        $query   = $this->db->query("SELECT 
    c.id_customer,
    c.kode_customer,
    c.phone_customer,
    c.nama_customer,
    c.nama_paket,
    c.name_pppoe,
    c.password_pppoe,
    c.id_pppoe,
    c.id_pppoe_paiton,
    c.alamat_customer,
    c.email_customer,
    DAY(c.start_date) AS tanggal,
    c.stop_date,
    c.nama_area,
    c.deskripsi_customer,
    c.nama_sales,
    c.disabled,
    c.disabled_paiton,
    c.kode_mikrotik,
    c.kode_mikrotik_paiton,
    p.nama_paket AS namaPaket,
    p.harga_paket
FROM 
    data_customer c
LEFT JOIN 
    data_paket p ON c.id_paket = p.id_paket
LEFT JOIN 
    data_pembayaran dp ON c.name_pppoe = dp.name_pppoe 
    AND MONTH(dp.transaction_time) = '$bulan'   
    AND YEAR(dp.transaction_time) = '$tahun'
WHERE 
    c.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir'
    AND dp.transaction_time IS NULL
    AND c.kode_mikrotik = '$cluster' AND  c.nama_paket != 'EXPIRED'
ORDER BY 
    c.nama_customer ASC;
");

        return $query->result_array();
    }


    // Menampilkan Jumlah Belum Lunas
    public function JumlahBelumLunas($bulan, $tahun, $tanggalAkhir, $cluster)
    {
        $query   = $this->db->query("SELECT 
        data_customer.id_customer

        FROM data_customer
        LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NULL AND
        data_customer.kode_mikrotik = '$cluster' AND
        data_customer.nama_paket != 'EXPIRED'

        GROUP BY data_customer.name_pppoe
        ORDER BY DAY(data_customer.start_date) ASC");

        return $query->num_rows();
    }

    // Menampilkan Jumlah Nominal Belum Lunas

    public function NominalBelumLunas($bulan, $tahun, $tanggalAkhir, $cluster)
    {
        $result   = $this->db->query("SELECT 
        SUM(data_paket.harga_paket) AS hargaPaket

        FROM data_customer 
        LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
        
        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir'
        AND data_pembayaran.transaction_time IS NULL 
        AND data_customer.kode_mikrotik = '$cluster' AND
        data_customer.nama_paket != 'EXPIRED'");

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
            data_customer.kode_mikrotik,
            data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
            data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
            data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
            data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket,
            data_customer.id_pppoe_paiton, data_customer.disabled_paiton, data_customer.kode_mikrotik_paiton

            FROM data_customer
            LEFT JOIN data_paket ON data_customer.id_paket = data_paket.id_paket
            LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe

            WHERE data_customer.id_customer = '$id_customer'
    
            GROUP BY data_customer.name_pppoe
            ORDER BY DAY(data_customer.start_date) ASC");

        return $query->result_array();
    }

    // Check duplicate pembayaran
    public function CheckDuplicatePayment($bulan, $tahun, $nama)
    {
        $this->db->select('name_pppoe, nama_paket, status_code, transaction_time, MONTH(transaction_time) as bulan_payment, YEAR(transaction_time) as tahun_payment');
        $this->db->where('MONTH(transaction_time)', $bulan);
        $this->db->where('YEAR(transaction_time)', $tahun);
        $this->db->where('name_pppoe', $nama);

        $this->db->limit(1);
        $result = $this->db->get('data_pembayaran');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
