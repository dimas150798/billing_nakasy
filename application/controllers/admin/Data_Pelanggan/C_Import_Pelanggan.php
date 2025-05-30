<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_Import_Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Mencegah caching agar tidak bisa kembali ke halaman setelah logout
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        if ($this->session->userdata('email') == null) {
            $this->session->set_flashdata('BelumLogin_icon', 'error');
            $this->session->set_flashdata('BelumLogin_title', 'Login Terlebih Dahulu');
            redirect('C_FormLogin');
        }
    }

    public function index()
    {
        $data['DataExcel']      = $this->M_ImportExcel->DataExcel();

        $this->load->view('template/admin/V_Header');
        $this->load->view('template/admin/V_Sidebar');
        $this->load->view('admin/Data_Pelanggan/V_Import_Pelanggan', $data);
        $this->load->view('template/admin/V_Footer');
    }

    public function ImportExcel()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $upload_status = $this->uploadDoc();
            if ($upload_status === false) {
                $this->session->set_flashdata('Tambah_icon', 'error');
                $this->session->set_flashdata('Tambah_title', 'Upload file gagal');
                redirect($_SERVER['HTTP_REFERER']);
                return;
            }

            $inputFileName = 'assets/imports/' . $upload_status;
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($inputFileName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            for ($i = 4; $i < count($sheetData); $i++) {
                $row = $sheetData[$i];

                $kode_customer      = $row[1] ?? '';
                $nama_customer      = $row[2] ?? '';
                $phone_customer     = $row[3] ?? '';
                $nama_paket         = $row[4] ?? '';
                $id_pppoe           = $row[5] ?? '';
                $name_pppoe         = $row[6] ?? '';
                $password_pppoe     = $row[7] ?? '';
                $alamat_customer    = $row[8] ?? '';
                $email_customer     = $row[9] ?? '';
                $start_date         = $row[10] ?? '';
                $nama_area          = $row[11] ?? '';
                $nama_sales         = $row[12] ?? '';

                $Get_Paket  = $this->M_Paket->Check_NamaPaket($nama_paket);
                $Get_Area   = $this->M_Area->Check_NamaArea($row[11]);
                $Get_Sales  = $this->M_Sales->Check_NamaSales($row[12]);

                $data_customer = [
                    'kode_customer'   => $kode_customer,
                    'phone_customer'  => $phone_customer,
                    'nama_customer'   => $nama_customer,
                    'id_paket'        => $Get_Paket->id_paket,
                    'nama_paket'      => $nama_paket,
                    'name_pppoe'      => $name_pppoe,
                    'password_pppoe'  => $password_pppoe,
                    'id_pppoe'        => $id_pppoe,
                    'alamat_customer' => $alamat_customer,
                    'email_customer'  => $email_customer,
                    'start_date'      => $start_date,
                    // 'id_area'         => $Get_Area->id_area,
                    // 'id_sales'        => $Get_Sales->id_sales,
                    'nama_area'       => $nama_area,
                    'nama_sales'      => $nama_sales,
                ];

                // kondisi insert / update
                $conditionData          = $this->M_CRUD->get('data_customer', "name_pppoe='$name_pppoe'")->result_array();

                // Get data data_customer
                $getData                = $this->db->query("SELECT id_customer, kode_customer, phone_customer, latitude, longitude, nama_customer, nama_paket, name_pppoe, password_pppoe, id_pppoe, alamat_customer, email_customer, start_date, stop_date, nama_area, deskripsi_customer, nama_sales, created_at, updated_at FROM data_customer
                ")->result_array();

                // condition update
                if (count($conditionData) != 0) {
                    foreach ($getData as $data) {
                        if ($data['name_pppoe'] == $sheetData[$i]['6']) {
                            $this->db->update("data_customer", ['id_area' => $Get_Area->id_area], ['name_pppoe' => $data['name_pppoe']]);
                            $this->db->update("data_customer", ['id_sales' => $Get_Sales->id_sales], ['name_pppoe' => $data['name_pppoe']]);
                            // $this->db->update("data_customer", ['nama_sales' => $row[12] ?? ''], ['name_pppoe' => $data['name_pppoe']]);
                            // $this->db->update("data_customer", ['nama_area' => $row[11] ?? ''], ['name_pppoe' => $data['name_pppoe']]);

                            echo "
                            <script>history.go(-1);            
                            </script>
                            ";

                            // Notifikasi Tambah Data Berhasil
                            $this->session->set_flashdata('Tambah_icon', 'success');
                            $this->session->set_flashdata('Tambah_title', 'Update Data Berhasil');
                        }
                    }
                }

                // condition insert
                if (count($conditionData) == 0) {
                    $this->M_CRUD->insertData($data_customer, 'data_customer');

                    echo "
                    <script>history.go(-1);            
                    </script>
                    ";

                    // Notifikasi Tambah Data Berhasil
                    $this->session->set_flashdata('Tambah_icon', 'success');
                    $this->session->set_flashdata('Tambah_title', 'Insert Data Berhasil');
                }
            }
        }
    }


    function uploadDoc()
    {
        $uploadPath = 'assets/imports/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 1000000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);


        if ($this->upload->do_upload('upload_excel')) {
            $fileData = $this->upload->data();
            $data['file_name'] = $fileData['file_name'];
            $this->db->insert('data_excel', $data);


            $insert_id = $this->db->insert_id();
            $_SESSION['lastid'] = $insert_id;

            return $fileData['file_name'];
        } else {
            return false;
        }
    }
}
