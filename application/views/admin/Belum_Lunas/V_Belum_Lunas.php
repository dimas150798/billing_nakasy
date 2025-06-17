<!-- Main Content -->
<div class="container-fluid px-10 py-4 flex-grow-1">

    <!-- Info dan Filter -->
    <div class="card shadow rounded-4 px-5 bg-dark text-white border-0 mb-4">

        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">

                <!-- Informasi Status -->
                <div>
                    <!-- Baris Pembayaran -->
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                        <span class="fw-semibold mb-0">Pembayaran :</span>
                        <span class="badge bg-danger text-white fs-6 px-3 py-2 rounded-pill">Belum Lunas</span>
                    </div>

                    <!-- Info Jumlah dan Nominal -->
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bx bx-user fs-5 text-primary"></i>
                            <span class="fw-semibold">Jumlah :</span>
                            <span class="badge bg-primary text-white fs-6 px-3 py-2 rounded-pill"><?= $Jumlah_BelumLunas ?></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bx bx-money fs-5 text-success"></i>
                            <span class="fw-semibold">Nominal :</span>
                            <span class="badge bg-success text-white fs-6 px-3 py-2 rounded-pill"><?= number_format($Nominal_BelumLunas, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>


                <!-- Filter -->
                <form class="row row-cols-1 row-cols-md-auto g-3 align-items-end" action="<?= base_url('admin/Belum_Lunas/C_Belum_Lunas') ?>" method="get">
                    <div>
                        <label class="form-label text-white fw-semibold mb-1">Tahun</label>
                        <select class="form-select form-select-sm text-white bg-dark border-secondary text-center fw-semibold shadow-sm" name="tahun" required>
                            <option value="" disabled selected class="text-muted">-- Pilih Tahun --</option>
                            <?php
                            $selectedYear = $this->session->userdata('tahunGET') ?: $this->session->userdata('tahun');
                            for ($i = 2022; $i <= 2025; $i++) {
                                $selected = ($selectedYear == $i) ? 'selected' : '';
                                echo "<option value='$i' $selected style='color:white; background-color:#212529;'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-white fw-semibold mb-1">Bulan</label>
                        <select class="form-select form-select-sm text-white bg-dark border-secondary text-center fw-semibold shadow-sm" name="bulan" required>
                            <option value="" disabled selected class="text-muted">-- Pilih Bulan --</option>
                            <?php
                            $selectedMonth = $this->session->userdata('bulanGET') ?: $this->session->userdata('bulan');
                            for ($m = 1; $m <= 12; $m++) {
                                $selected = ($selectedMonth == $m) ? 'selected' : '';
                                $monthName = date('F', mktime(0, 0, 0, $m, 1));
                                echo "<option value='$m' $selected style='color:white; background-color:#212529;'>$monthName</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-info text-white fw-semibold px-4 shadow-sm">
                            <i class="fas fa-eye me-2"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alert -->
        <?php if ($this->session->flashdata('success_transaksi')): ?>
            <div class="alert alert-success alert-dismissible fade show text-center m-3" role="alert">
                <?= $this->session->flashdata('success_transaksi'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="controls">
        <div class="left-control">
            <label>
                Tampilkan
                <select id="rowsPerPage">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                </select>
                entri per halaman
            </label>
        </div>

        <div class="right-control">
            <input type="search" id="searchInput" placeholder="🔍 Cari nama, ID, paket...">
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="sortable" data-index="1">Nama <span class="sort-icon"></span></th>
                    <th class="sortable" data-index="2">ID <span class="sort-icon"></span></th>
                    <th class="sortable" data-index="3">Paket <span class="sort-icon"></span></th>
                    <th class="sortable" data-index="4">Tarif <span class="sort-icon"></span></th>
                    <th class="sortable" data-index="5">Status <span class="sort-icon"></span></th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                    <td colspan="7">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="pagination" id="pagination"></div>
</div>