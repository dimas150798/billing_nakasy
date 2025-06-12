<?php

ini_set('display_errors', 1);
error_reporting(E_ALL && ~E_NOTICE);

class M_Mikrotik_Kraksaan extends CI_Model
{
    public function index()
    {
        $response = [];

        // Connect to MikroTik API
        $api = Connect_Kraksaaan();
        $Get_Mikrotik = $api->comm('/ppp/secret/print');
        $api->disconnect();

        $Nama_Paket = array(
            '2M' => '2M',
            'EXPIRED' => 'EXPIRED',
            'HOME 10' => 'HOME 10',
            'HOME 20' => 'HOME 20',
            'HOME 30' => 'HOME 30',
            'HOME 50' => 'HOME 50',
            'HOME 100' => 'HOME 100',
            'HOME 200' => 'HOME 200',
            'INET-5M' => 'INET-5M',
            'INET-10M' => 'INET-10M',
            'INET-20M' => 'INET-20M',
            'INET-30M' => 'INET-30M',
            'INET-50M' => 'INET-50M',
            'INET-100M' => 'INET-100M',
            'INET-300M' => 'INET-300M'
        );

        // Fetch data from the database
        $Get_Data = $this->db->query("SELECT id_customer, nama_customer, name_pppoe, password_pppoe, kode_mikrotik, disabled, nama_paket
        FROM data_customer")->result_array();

        $insertData = [];
        $updateData = [];
        $updateDataMikrotik = [];

        foreach ($Get_Mikrotik as $keySecret => $Show_Mikrotik) {
            $status = false;

            foreach ($Get_Data as $key => $Show_Data) {

                if ($Show_Mikrotik['name'] == $Show_Data['name_pppoe']) {
                    $status = true;

                    if ($Show_Data['kode_mikrotik'] == NULL) {
                        $updateData[] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Mikrotik['name'],
                            'id_pppoe'      => $Show_Mikrotik['.id'],
                            'disabled'      => $Show_Mikrotik['disabled'],
                            'kode_mikrotik' => 'Kraksaan',
                            'updated_at'    => date('Y-m-d H:i:s', time()),
                        ];

                        $response[$keySecret] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Mikrotik['name'],
                            'nama_customer' => $Show_Data['nama_customer'],
                            'nama_paket'    => $Nama_Paket[$Show_Mikrotik['profile']],
                            'updated_at'    => date('Y-m-d H:i:s', time()),
                        ];
                    }

                    if ($Show_Data['kode_mikrotik'] != NULL) {
                        $updateData[] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Mikrotik['name'],
                            'id_pppoe'      => $Show_Mikrotik['.id'],
                            'disabled'      => $Show_Mikrotik['disabled'],
                            'kode_mikrotik' => 'Kraksaan',
                            'updated_at'    => date('Y-m-d H:i:s', time()),
                        ];

                        $response[$keySecret] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Data['kode_customer'],
                            'nama_customer' => $Show_Data['nama_customer'],
                            'nama_paket'    => $Nama_Paket[$Show_Mikrotik['profile']],
                            'updated_at'    => date('Y-m-d H:i:s', time()),
                        ];
                    }
                }
            }

            if ($status == false) {
                $insertData[] = [
                    'kode_customer'     => $Show_Mikrotik['name'],
                    'phone_customer'    => '0',
                    'nama_customer'     => $Show_Mikrotik['name'],
                    'nama_paket'        => $Nama_Paket[$Show_Mikrotik['profile']],
                    'name_pppoe'        => $Show_Mikrotik['name'],
                    'password_pppoe'    => $Show_Mikrotik['password'],
                    'id_pppoe'          => $Show_Mikrotik['.id'],
                    'alamat_customer'   => '0',
                    'email_customer'    => '0',
                    'disabled'          => $Show_Mikrotik['disabled'],
                    'kode_mikrotik'     => 'Kraksaan',
                    'created_at'        => date('Y-m-d H:i:s', time()),
                    'updated_at'        => date('Y-m-d H:i:s', time()),
                ];
            }
        }

        if (!empty($updateData)) {
            $this->db->update_batch("data_customer", $updateData, 'id_customer');
        }

        if (!empty($insertData)) {
            $this->db->insert_batch("data_customer", $insertData);
        }

        return $response;
    }

    public function Terminasi_Kraksaan($bulan, $tahun, $tanggalAkhir)
    {
        date_default_timezone_set("Asia/Jakarta");
        $day = date("d");

        if ($day != '11') {
            return "Belum tanggal 11.";
        }

        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
        data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
        DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales, data_customer.disabled, 
        data_customer.kode_mikrotik,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket

        FROM data_customer
        LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NULL AND
        data_customer.disabled = 'false' AND data_customer.kode_mikrotik = 'Kraksaan'

        ORDER BY data_customer.nama_customer ASC

        LIMIT 100
        ")->result_array();

        if (empty($getData)) {
            return "Tidak ada pelanggan yang perlu dinonaktifkan.";
        }

        $updateData = [];
        $api = Connect_Kraksaaan(); // koneksi API hanya sekali


        foreach ($getData as $data) {
            // Disable secret
            $api->comm('/ppp/secret/set', [
                ".id" => $data['id_pppoe'],
                "disabled" => 'true',
            ]);

            // Disable active
            $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
            if (!empty($ambilid)) {
                $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
            }

            // Siapkan untuk update batch database
            $updateData[] = [
                'name_pppoe' => $data['name_pppoe'],
                'disabled'   => 'true',
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $api->disconnect();

        if (!empty($updateData)) {
            $this->db->update_batch("data_customer", $updateData, 'name_pppoe');
        } else {
            return "Tidak ada yang perlu diperbarui.";
        }
    }


    public function Enable_Kraksaan($bulan, $tahun, $tanggalAkhir)
    {
        $getData = $this->db->query("SELECT 
            data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, 
            data_customer.nama_customer, data_customer.nama_paket, data_customer.name_pppoe, 
            data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, 
            data_customer.email_customer, DAY(data_customer.start_date) as tanggal, 
            data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, 
            data_customer.nama_sales, data_customer.disabled, data_pembayaran.order_id, 
            data_pembayaran.gross_amount, data_pembayaran.biaya_admin, data_pembayaran.nama_admin, 
            data_pembayaran.keterangan, data_pembayaran.payment_type, 
            data_pembayaran.transaction_time, data_pembayaran.expired_date, data_pembayaran.bank, 
            data_pembayaran.va_number, data_pembayaran.permata_va_number, 
            data_pembayaran.payment_code, data_pembayaran.bill_key, 
            data_pembayaran.biller_code, data_pembayaran.pdf_url, 
            data_pembayaran.status_code, data_paket.nama_paket as namaPaket, 
            data_paket.harga_paket
        FROM data_customer
        LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
            AND MONTH(data_pembayaran.transaction_time) = '$bulan' 
            AND YEAR(data_pembayaran.transaction_time) = '$tahun'
        WHERE 
            data_customer.start_date BETWEEN '2020-10-01' AND '$tanggalAkhir'
            AND data_customer.disabled = 'true'
            AND data_pembayaran.transaction_time IS NOT NULL 
            AND data_customer.kode_mikrotik = 'Kraksaan'
            AND data_customer.nama_paket != 'EXPIRED'
            
        ORDER BY data_customer.nama_customer ASC
        LIMIT 100
    ")->result_array();

        // ✅ Cek jika ada data pelanggan yang perlu di-enable
        if (!empty($getData)) {
            $api = Connect_Kraksaaan();

            foreach ($getData as $data) {

                // Aktifkan kembali PPPoE (enable secret)
                $api->comm('/ppp/secret/set', [
                    ".id" => $data['id_pppoe'],
                    "disabled" => 'false',
                ]);
            }

            $api->disconnect(); // Tutup koneksi setelah selesai
        } else {
            echo "Tidak ada pelanggan yang perlu diaktifkan.";
        }
    }
}
