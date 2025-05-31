<?php
$months = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

?>

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Kwitansi Lunas by WA</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">

                <?php foreach ($Data_Pelanggan as $data) : ?>
                    <form method="POST" action="<?php echo base_url('admin/Sudah_Lunas/C_Kirim_WA_Lunas/KirimWA_Aksi') ?>">
                        <div class="row g-4">

                            <!-- Hidden Values -->
                            <input type="hidden" name="kode_customer" value="<?= $data['kode_customer'] ?>" readonly>
                            <input type="hidden" name="bulan_transaksi" value="<?= ($months[$data['bulan_payment']] ?? '-') . ' ' . $data['tahun_payment'] ?>" readonly>
                            <input type="hidden" name="tahun_transaksi" value="<?= $data['tahun_payment'] ?>" readonly>
                            <input type="hidden" name="hari_transaksi" value="<?= $data['tanggal'] ?>" readonly>

                            <!-- Nama Pelanggan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Nama Pelanggan: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" name="nama_customer" value="<?= ucwords(strtolower($data['nama_customer'])) ?>" readonly>
                                </div>
                            </div>

                            <!-- Name PPPOE -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Name PPPOE: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-badge-fill"></i></span>
                                    <input type="text" class="form-control" name="name_pppoe" value="<?= $data['name_pppoe'] ?>" readonly>
                                </div>
                            </div>

                            <!-- Tanggal Pembayaran -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Tanggal Pembayaran: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-event"></i></span>
                                    <input type="text" class="form-control" name="transaction_time"
                                        value="<?= $data['tanggal'] . ' / ' .  ($months[$data['bulan_payment']] ?? '-') . ' / ' . $data['tahun_payment'] ?>"
                                        readonly>
                                </div>
                            </div>


                            <!-- Telepon Pelanggan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Telepon Pelanggan: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="text" class="form-control" name="phone_customer" value="<?= $data['phone_customer'] ?>" readonly>
                                </div>
                            </div>

                            <!-- Nama Paket -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Nama Paket: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-wifi"></i></span>
                                    <input type="text" class="form-control" name="nama_paket" value="<?= $data['nama_paket'] ?>" readonly>
                                </div>
                            </div>

                            <!-- Harga Paket -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Harga Paket Internet: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-cash-coin"></i></span>
                                    <input type="text" class="form-control" name="harga_paket" value="<?= number_format($data['harga_paket'], 0, ',', '.') ?>" readonly>
                                </div>
                            </div>

                            <!-- Biaya Admin -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Biaya Admin: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-currency-dollar"></i></span>
                                    <input type="text" class="form-control" name="biaya_admin" value="<?= number_format($data['biaya_admin'], 0, ',', '.') ?>" readonly>
                                </div>
                            </div>

                            <!-- Total Pembayaran -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Total Pembayaran: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-wallet2"></i></span>
                                    <input type="text" class="form-control" name="gross_amount"
                                        value="<?= number_format($data['gross_amount'], 0, ',', '.') ?>" readonly>
                                </div>
                            </div>

                        </div>

                        <!-- Button -->
                        <div class="mt-6 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">Kirim</button>
                        </div>

                    </form>
                <?php endforeach; ?>

            </div>
            <!-- /Account -->
        </div>
    </div>
    <!-- / Content -->
</div>