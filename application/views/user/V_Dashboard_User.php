<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">

            <!-- Total Cards Section (Compact Version) -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 mb-4">
                <div class="col">
                    <div class="bg-light border-start border-info border-4 rounded-3 shadow-sm p-2 h-100">
                        <small class="text-muted d-block mb-1">Total Pelanggan Belum Lunas</small>
                        <div class="text-dark fw-semibold fs-6"><?= $Jumlah_Pelanggan ?? '0' ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-light border-start border-primary border-4 rounded-3 shadow-sm p-2 h-100">
                        <small class="text-muted d-block mb-1">Estimasi Tagihan Berlangganan (Paket)</small>
                        <div class="text-dark fw-semibold fs-6">Rp <?= number_format($Nominal_Tagihan, 0, ',', '.') ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-light border-start border-warning border-4 rounded-3 shadow-sm p-2 h-100">
                        <small class="text-muted d-block mb-1">Total Pendapatan Penagih</small>
                        <div class="text-dark fw-semibold fs-6">Rp <?= number_format($Nominal_Fee, 0, ',', '.') ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-light border-start border-success border-4 rounded-3 shadow-sm p-2 h-100">
                        <small class="text-muted d-block mb-1">Total Akhir</small>
                        <div class="text-dark fw-semibold fs-6">Rp <?= number_format($Total_Akhir, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- / Content -->
</div>