<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_UP_Down extends CI_Controller
{
    public function Mikrotik_Kraksaan()
    {
        header('Content-Type: application/json');
        date_default_timezone_set("Asia/Jakarta");

        $api = Connect_Kraksaaan();

        if (!$api) {
            echo json_encode([
                'success' => false,
                'message' => '❌ Tidak bisa connect ke MikroTik.'
            ]);
            return;
        }

        // Ambil semua secret PPPoE
        $api->write('/ppp/secret/print');
        $secrets = $api->read();
        $all_users = [];
        $secret_data = [];

        foreach ($secrets as $s) {
            if (isset($s['disabled']) && $s['disabled'] === 'false') {
                $username = $s['name'];
                $all_users[] = $username;

                $last_logged_out_raw = $s['last-logged-out'] ?? null;
                $converted_last_logged_out = $this->convertLastLoggedOutToDatetime($last_logged_out_raw);

                $secret_data[$username] = [
                    'last_logged_out' => $converted_last_logged_out,
                    'last_caller_id' => $s['last-caller-id'] ?? '-',
                    'last_disconnect_reason' => $s['last-disconnect-reason'] ?? '-',
                    'comment' => $s['comment'] ?? '-',
                ];
            }
        }

        // Ambil semua active PPPoE
        $api->write('/ppp/active/print');
        $actives = $api->read();
        $active_users = [];
        $active_uptimes = [];

        foreach ($actives as $a) {
            $username = $a['name'];
            $active_users[] = $username;
            $active_uptimes[$username] = $a['uptime'] ?? '-';
        }

        $updated = 0;
        $inserted = 0;
        $skipped = 0;

        foreach ($all_users as $du) {
            if (!isset($secret_data[$du])) continue;
            $info = $secret_data[$du];

            if (in_array($du, $active_users)) {
                // Pelanggan UP, update semua status DOWN menjadi UP + waktu UP
                $this->M_CRUD->updateData(
                    'data_gangguan_customer',
                    [
                        'status' => 'UP',
                        'up_time' => $active_uptimes[$du],
                        'updated_at' => date('Y-m-d H:i:s')
                    ],
                    ['name_pppoe' => $du, 'status' => 'DOWN']
                );
                $updated++;
            } else {
                // Pelanggan DOWN, cek apakah sudah ada tiket aktif status DOWN
                $cek_down = $this->db
                    ->where('name_pppoe', $du)
                    ->where('status', 'DOWN')
                    ->limit(1)
                    ->get('data_gangguan_customer')
                    ->row();

                if (!$cek_down) {
                    // Hitung jumlah gangguan sebelumnya
                    $jumlah_gangguan = $this->db
                        ->where('name_pppoe', $du)
                        ->count_all_results('data_gangguan_customer') + 1;

                    // Generate tiket_id otomatis
                    $tiket_id = 'NKY-' . date('Ymd-His') . '-' . rand(100, 999);

                    // Insert tiket baru gangguan
                    $data_gangguan = [
                        'tiket_id' => $tiket_id,
                        'name_pppoe' => $du,
                        'last_logged_out' => ($info['last_logged_out'] === '1970-01-01 00:00:00' || empty($info['last_logged_out']))
                            ? null
                            : $info['last_logged_out'],
                        'last_caller_id' => $info['last_caller_id'],
                        'last_disconnect_reason' => $info['last_disconnect_reason'],
                        'status' => 'DOWN',
                        'jumlah_gangguan' => $jumlah_gangguan,
                        'kode_mikrotik' => 'Kraksaan',
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    $this->M_CRUD->insertData($data_gangguan, 'data_gangguan_customer');
                    $inserted++;
                } else {
                    // Tiket DOWN sudah ada, update last_logged_out dan last_disconnect_reason agar fresh

                    $this->M_CRUD->updateData(
                        'data_gangguan_customer',
                        [
                            'last_logged_out' => ($info['last_logged_out'] === '1970-01-01 00:00:00' || empty($info['last_logged_out']))
                                ? null
                                : $info['last_logged_out'],
                            'last_caller_id' => $info['last_caller_id'],
                            'last_disconnect_reason' => $info['last_disconnect_reason'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ],
                        [
                            'id_gangguan' => $cek_down->id_gangguan
                        ]
                    );

                    $skipped++; // jika ingin ganti label, misal $updated_down_existing++
                }
            }
        }

        $api->disconnect();

        echo json_encode([
            'success' => true,
            'message' => '✅ Status pelanggan telah diperbarui di database.',
            'updated_to_UP' => $updated,
            'inserted_DOWN' => $inserted,
            'skipped_already_exists' => $skipped,
            'converted_last_logged_out' => $converted_last_logged_out,
            'total_checked' => count($all_users),
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    public function Mikrotik_Paiton()
    {
        header('Content-Type: application/json');
        date_default_timezone_set("Asia/Jakarta");

        $api = Connect_Paiton();

        if (!$api) {
            echo json_encode([
                'success' => false,
                'message' => '❌ Tidak bisa connect ke MikroTik.'
            ]);
            return;
        }

        // Ambil semua secret PPPoE
        $api->write('/ppp/secret/print');
        $secrets = $api->read();
        $all_users = [];
        $secret_data = [];

        var_dump($secrets);

        foreach ($secrets as $s) {
            if (isset($s['disabled']) && $s['disabled'] === 'false') {
                $username = $s['name'];
                $all_users[] = $username;

                $last_logged_out_raw = $s['last-logged-out'] ?? null;
                $converted_last_logged_out = $this->convertLastLoggedOutToDatetime($last_logged_out_raw);

                $secret_data[$username] = [
                    'last_logged_out' => $converted_last_logged_out,
                    'last_caller_id' => $s['last-caller-id'] ?? '-',
                    'last_disconnect_reason' => $s['last-disconnect-reason'] ?? '-',
                    'comment' => $s['comment'] ?? '-',
                ];
            }
        }

        // Ambil semua active PPPoE
        $api->write('/ppp/active/print');
        $actives = $api->read();
        $active_users = [];
        $active_uptimes = [];

        foreach ($actives as $a) {
            $username = $a['name'];
            $active_users[] = $username;
            $active_uptimes[$username] = $a['uptime'] ?? '-';
        }

        $updated = 0;
        $inserted = 0;
        $skipped = 0;

        foreach ($all_users as $du) {
            if (!isset($secret_data[$du])) continue;
            $info = $secret_data[$du];

            if (in_array($du, $active_users)) {
                // Pelanggan UP, update semua status DOWN menjadi UP + waktu UP
                $this->M_CRUD->updateData(
                    'data_gangguan_customer',
                    [
                        'status' => 'UP',
                        'up_time' => $active_uptimes[$du],
                        'updated_at' => date('Y-m-d H:i:s')
                    ],
                    ['name_pppoe' => $du, 'status' => 'DOWN']
                );
                $updated++;
            } else {
                // Pelanggan DOWN, cek apakah sudah ada tiket aktif status DOWN
                $cek_down = $this->db
                    ->where('name_pppoe', $du)
                    ->where('status', 'DOWN')
                    ->limit(1)
                    ->get('data_gangguan_customer')
                    ->row();

                if (!$cek_down) {
                    // Hitung jumlah gangguan sebelumnya
                    $jumlah_gangguan = $this->db
                        ->where('name_pppoe', $du)
                        ->count_all_results('data_gangguan_customer') + 1;

                    // Generate tiket_id otomatis
                    $tiket_id = 'NKY-' . date('Ymd-His') . '-' . rand(100, 999);


                    // Insert tiket baru gangguan
                    $data_gangguan = [
                        'tiket_id' => $tiket_id,
                        'name_pppoe' => $du,
                        'last_logged_out' => ($info['last_logged_out'] === '1970-01-01 00:00:00' || empty($info['last_logged_out']))
                            ? null
                            : $info['last_logged_out'],
                        'last_caller_id' => $info['last_caller_id'],
                        'last_disconnect_reason' => $info['last_disconnect_reason'],
                        'status' => 'DOWN',
                        'jumlah_gangguan' => $jumlah_gangguan,
                        'kode_mikrotik' => 'Paiton',
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    $this->M_CRUD->insertData($data_gangguan, 'data_gangguan_customer');
                    $inserted++;
                } else {
                    // Tiket DOWN sudah ada, update last_logged_out dan last_disconnect_reason agar fresh

                    $this->M_CRUD->updateData(
                        'data_gangguan_customer',
                        [
                            'last_logged_out' => ($info['last_logged_out'] === '1970-01-01 00:00:00' || empty($info['last_logged_out']))
                                ? null
                                : $info['last_logged_out'],
                            'last_caller_id' => $info['last_caller_id'],
                            'last_disconnect_reason' => $info['last_disconnect_reason'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ],
                        [
                            'id_gangguan' => $cek_down->id_gangguan
                        ]
                    );

                    $skipped++; // jika ingin ganti label, misal $updated_down_existing++
                }
            }
        }

        $api->disconnect();

        echo json_encode([
            'success' => true,
            'message' => '✅ Status pelanggan telah diperbarui di database.',
            'updated_to_UP' => $updated,
            'inserted_DOWN' => $inserted,
            'skipped_already_exists' => $skipped,
            'converted_last_logged_out' => $converted_last_logged_out,
            'total_checked' => count($all_users),
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    function convertLastLoggedOutToDatetime($input)
    {
        if (empty($input) || strtolower($input) === 'unknown') {
            return null;
        }

        $input = trim($input);

        // Jika sudah dalam format YYYY-MM-DD HH:MM:SS, validasi dan return
        $dt_check = DateTime::createFromFormat('Y-m-d H:i:s', $input);
        if ($dt_check && $dt_check->format('Y-m-d H:i:s') === $input) {
            return $input;
        }

        // Parsing format MikroTik "jul/6/2025 08:56:47"
        $parts = explode(' ', $input);
        if (count($parts) != 2) {
            return null;
        }

        $datePart = strtolower($parts[0]); // 'jul/6/2025'
        $timePart = $parts[1];             // '08:56:47'

        $dateSegments = explode('/', $datePart);
        if (count($dateSegments) != 3) {
            return null;
        }

        $monthMap = [
            'jan' => '01',
            'feb' => '02',
            'mar' => '03',
            'apr' => '04',
            'may' => '05',
            'jun' => '06',
            'jul' => '07',
            'aug' => '08',
            'sep' => '09',
            'oct' => '10',
            'nov' => '11',
            'dec' => '12'
        ];

        $month_key = substr($dateSegments[0], 0, 3);
        $month = $monthMap[$month_key] ?? null;
        $day = str_pad($dateSegments[1], 2, '0', STR_PAD_LEFT);
        $year = $dateSegments[2];

        if (!$month) {
            return null;
        }

        $formatted = "$year-$month-$day $timePart";

        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $formatted);
        if ($dt) {
            return $dt->format('Y-m-d H:i:s');
        } else {
            return null;
        }
    }
}
