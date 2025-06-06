<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e9f0ff, #fefefe);
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .receipt-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .receipt {
            background: #ffffff;
            padding: 20px 16px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #5a8dee;
        }

        .receipt h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 6px;
            color: #5a5a5a;
        }

        .receipt h4 {
            text-align: center;
            font-size: 14px;
            margin-top: 16px;
            color: #5a8dee;
        }

        .receipt p {
            margin: 6px 0;
            font-size: 14px;
            color: #333;
        }

        .receipt .section-title {
            font-weight: 600;
            margin: 12px 0 6px;
            border-top: 1px dashed #ccc;
            padding-top: 8px;
            color: #444;
            font-size: 14px;
        }

        .center {
            text-align: center;
        }

        .highlight {
            color: #5a8dee;
            font-weight: bold;
        }

        .info-icon {
            margin-right: 5px;
            color: #5a8dee;
        }

        .print-btn {
            margin: 24px auto 0;
            padding: 10px 20px;
            font-size: 15px;
            background-color: #5a8dee;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            transition: background 0.3s ease;
        }

        .print-btn:hover {
            background-color: #497ad9;
        }

        @media (max-width: 480px) {
            .receipt {
                padding: 16px 12px;
            }

            .receipt p,
            .receipt .section-title {
                font-size: 13px;
            }

            .receipt h2 {
                font-size: 20px;
            }
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .print-btn {
                display: none !important;
            }

            .receipt-wrapper {
                width: 58mm;
                box-shadow: none;
                margin: 0 auto;
            }

            .receipt {
                padding: 10px;
                box-shadow: none;
                border-radius: 0;
                border: none;
            }

            .receipt p,
            .receipt .section-title {
                font-size: 11px;
            }

            .receipt h2 {
                font-size: 16px;
            }

            .receipt h4 {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <?php foreach ($Data_Pelanggan as $data) : ?>
        <div class="receipt-wrapper">
            <div class="receipt" id="receipt">
                <h2>INFLY NETWORKS</h2>
                <p class="center"><i class="info-icon">📍</i>Jl. Kp. Melayu, Kapuran, Kraksaan Wetan No. 63, Kabupaten Probolinggo</p>

                <br>

                <p><strong>NAMA:</strong> <span class="highlight"><?= htmlspecialchars($data['nama_customer']); ?></span></p>
                <p><strong>TELEPON:</strong> <?= htmlspecialchars($data['phone_customer']); ?></p>
                <p><strong>ID PELANGGAN:</strong> <?= strtoupper(htmlspecialchars($data['kode_customer'])); ?></p>
                <p><strong>ALAMAT:</strong> <?= ucwords(strtolower(htmlspecialchars($data['alamat_customer']))); ?></p>

                <p class="section-title">RINCIAN TRANSAKSI</p>
                <p><strong>BULAN:</strong> <?= date('F', strtotime($data['start_date'])); ?></p>
                <p><strong>PAKET:</strong> <?= htmlspecialchars($data['nama_paket']); ?></p>
                <p><strong>HARGA:</strong> Rp. <?= number_format($data['harga_paket'], 0, ',', '.'); ?></p>
                <p><strong>TOTAL:</strong> <span class="highlight">Rp. <?= number_format(($data['harga_paket'] + ($data['biaya_admin'] ?? 0)), 0, ',', '.'); ?></span></p>
                <p><strong>STATUS:</strong> <?= ($data['status_code'] == 200) ? '✅ SUDAH LUNAS' : '❌ BELUM BAYAR'; ?></p>
                <p><strong>ADMIN BY:</strong> <?= htmlspecialchars($data['nama_admin'] ?? 'Sistem'); ?></p>

                <p class="section-title center">Simpan struk ini sebagai bukti pembayaran.</p>
                <p class="center">☎ CS: 0812-129-954-04</p>
                <p class="center">☎ CS: 0851-343-836-70</p>

                <h4>Terima Kasih</h4>
            </div>

            <button class="print-btn" onclick="window.print()">🖨️ Print Kwitansi</button>
        </div>
    <?php endforeach; ?>

</body>

</html>