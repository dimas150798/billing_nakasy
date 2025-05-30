<?php

ini_set('display_errors', 1);
error_reporting(E_ALL && ~E_NOTICE);

class M_Mikrotik_Paiton extends CI_Model
{
    public function index()
    {
        $response = [];

        // Connect to MikroTik API
        $api = Connect_Paiton();
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
        $Get_Data = $this->db->query("SELECT id_customer, nama_customer, name_pppoe, password_pppoe, kode_mikrotik, disabled 
        FROM data_customer")->result_array();

        $insertData = [];
        $updateData = [];
        $updateDataMikrotik = [];

        foreach ($Get_Mikrotik as $keySecret => $Show_Mikrotik) {
            $status = false;

            foreach ($Get_Data as $key => $Show_Data) {
                $Get_Paket = $this->M_Paket->Check_NamaPaket($Show_Data['nama_paket']);

                if ($Show_Mikrotik['name'] == $Show_Data['name_pppoe']) {
                    $status = true;

                    if ($Show_Data['kode_mikrotik'] == NULL) {
                        $updateData[] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Mikrotik['name'],
                            'id_pppoe'      => $Show_Mikrotik['.id'],
                            'disabled'      => $Show_Mikrotik['disabled'],
                            'id_paket'      => $Get_Paket->id_paket,
                            'kode_mikrotik' => 'Paiton',
                            'updated_at'        => date('Y-m-d H:i:s', time()),
                        ];

                        $response[$keySecret] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Mikrotik['name'],
                            'nama_customer' => $Show_Data['nama_customer'],
                            'nama_paket'    => $Nama_Paket[$Show_Mikrotik['profile']],
                            'id_paket'      => $Get_Paket->id_paket,
                            'updated_at'    => date('Y-m-d H:i:s', time()),
                        ];
                    }

                    if ($Show_Data['kode_mikrotik'] != NULL) {
                        $updateData[] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Mikrotik['name'],
                            'id_pppoe'      => $Show_Mikrotik['.id'],
                            'disabled'      => $Show_Mikrotik['disabled'],
                            'id_paket'      => $Get_Paket->id_paket,
                            'kode_mikrotik' => 'Paiton',
                            'updated_at'    => date('Y-m-d H:i:s', time()),
                        ];

                        $response[$keySecret] = [
                            'id_customer'   => $Show_Data['id_customer'],
                            'kode_customer' => $Show_Data['kode_customer'],
                            'nama_customer' => $Show_Data['nama_customer'],
                            'nama_paket'    => $Nama_Paket[$Show_Mikrotik['profile']],
                            'id_paket'      => $Get_Paket->id_paket,
                            'updated_at'        => date('Y-m-d H:i:s', time()),
                        ];
                    }
                }
            }

            if ($status == false) {

                if (preg_match('/^[A-Z\s]+/i', $Show_Mikrotik['comment'], $matches)) {
                    $comment_mikrotik = trim($matches[0]);
                } else {
                    $comment_mikrotik = $Show_Mikrotik['name'];
                }

                $insertData[] = [
                    'kode_customer'     => '0',
                    'phone_customer'    => '0',
                    'nama_customer'     => $comment_mikrotik,
                    'id_paket'      => $Get_Paket->id_paket,
                    'nama_paket'        => $Nama_Paket[$Show_Mikrotik['profile']],
                    'name_pppoe'        => $Show_Mikrotik['name'],
                    'password_pppoe'    => $Show_Mikrotik['password'],
                    'id_pppoe'          => $Show_Mikrotik['.id'],
                    'alamat_customer'   => '0',
                    'email_customer'    => '0',
                    'disabled'          => $Show_Mikrotik['disabled'],
                    'kode_mikrotik'     => 'Paiton',
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
}
