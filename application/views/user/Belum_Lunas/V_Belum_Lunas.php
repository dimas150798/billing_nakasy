     <!-- Main Content -->
     <div class="container-fluid px-10 py-4 flex-grow-1">

         <!-- Header -->
         <div class="row">
             <div class="col-12">
                 <div class="p-4 bg-white shadow-sm rounded-4 mb-4 border border-0">

                     <!-- Judul -->
                     <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                         <span class="fw-semibold mb-0">Pembayaran :</span>
                         <span class="badge bg-danger text-white fs-6 px-3 py-2 rounded-pill">Belum Lunas</span>
                     </div>

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
                                 <small class="text-muted d-block mb-1">Estimasi Pendapatan Penagih</small>
                                 <div class="text-dark fw-semibold fs-6">Rp <?= number_format($Nominal_Fee, 0, ',', '.') ?></div>
                             </div>
                         </div>
                         <div class="col">
                             <div class="bg-light border-start border-success border-4 rounded-3 shadow-sm p-2 h-100">
                                 <small class="text-muted d-block mb-1">Estimasi Total Akhir</small>
                                 <div class="text-dark fw-semibold fs-6">Rp <?= number_format($Total_Akhir, 0, ',', '.') ?></div>
                             </div>
                         </div>
                     </div>


                     <!-- Filter Form -->
                     <form class="row row-cols-1 row-cols-md-auto g-3 align-items-end" action="<?= base_url('user/Belum_Lunas/C_Belum_Lunas') ?>" method="get">
                         <!-- Tahun -->
                         <div class="col">
                             <label for="tahun" class="form-label fw-semibold mb-1">Tahun</label>
                             <select class="form-select form-select-sm text-center fw-semibold" name="tahun" id="tahun" required>
                                 <option value="" disabled selected>-- Pilih Tahun --</option>
                                 <?php
                                    $selectedYear = $this->session->userdata('tahunGET') ?: $this->session->userdata('tahun');
                                    for ($i = 2022; $i <= 2025; $i++) {
                                        $selected = ($selectedYear == $i) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                             </select>
                         </div>

                         <!-- Bulan -->
                         <div class="col">
                             <label for="bulan" class="form-label fw-semibold mb-1">Bulan</label>
                             <select class="form-select form-select-sm text-center fw-semibold" name="bulan" id="bulan" required>
                                 <option value="" disabled selected>-- Pilih Bulan --</option>
                                 <?php
                                    $selectedMonth = $this->session->userdata('bulanGET') ?: $this->session->userdata('bulan');
                                    for ($m = 1; $m <= 12; ++$m) {
                                        $selected = ($selectedMonth == $m) ? 'selected' : '';
                                        echo "<option value='$m' $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
                                    }
                                    ?>
                             </select>
                         </div>

                         <!-- Button -->
                         <div class="col">
                             <button type="submit" class="btn btn-outline-info fw-semibold px-4">
                                 <i class="fas fa-eye me-2"></i> Tampilkan
                             </button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>

         <?php if ($this->session->flashdata('success_transaksi')): ?>
             <div class="alert alert-success text-dark alert-dismissible fade show text-center" role="alert">
                 <?= $this->session->flashdata('success_transaksi'); ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
         <?php endif; ?>

         <div class="controls">
             <input type="search" id="searchInput" placeholder="🔍 Cari nama, ID, paket...">

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