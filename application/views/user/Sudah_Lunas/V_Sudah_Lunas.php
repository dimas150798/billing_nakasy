     <!-- Main Content -->
     <div class="container-fluid px-10 py-4 flex-grow-1">

         <!-- Header -->
         <div class="row">
             <div class="col-12">
                 <div class="p-4 bg-white shadow-sm rounded-4 mb-4 border border-0">

                     <!-- Baris Pembayaran -->
                     <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                         <span class="fw-semibold mb-0">Pembayaran :</span>
                         <span class="badge bg-success text-white fs-6 px-3 py-2 rounded-pill">Sudah Lunas</span>
                     </div>

                     <!-- Total Cards Section (Compact Version) -->
                     <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 mb-4">
                         <div class="col">
                             <div class="bg-light border-start border-info border-4 rounded-3 shadow-sm p-2 h-100">
                                 <small class="text-muted d-block mb-1">Total Pelanggan Lunas</small>
                                 <div class="text-dark fw-semibold fs-6"><?= $Jumlah_SudahLunas ?? '0' ?></div>
                             </div>
                         </div>
                         <div class="col">
                             <div class="bg-light border-start border-primary border-4 rounded-3 shadow-sm p-2 h-100">
                                 <small class="text-muted d-block mb-1">Total Tagihan Lunas</small>
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


                     <!-- Filter Form -->
                     <form class="row row-cols-1 row-cols-md-auto g-3 align-items-end" action="<?= base_url('user/Sudah_Lunas/C_Sudah_Lunas') ?>" method="get">
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

         <!-- Table -->
         <div class="table-responsive" style="width: 100%;">
             <table id="mytable" class="table table-striped table-bordered w-100 responsive">
                 <thead class="table-light">
                     <tr>
                         <th class="text-center">No</th>
                         <th class="text-center">Nama</th>
                         <th class="text-center">ID</th>
                         <th class="text-center">Tanggal</th>
                         <th class="text-center">Paket</th>
                         <th class="text-center">Tarif</th>
                         <th class="text-center">Melalui</th>
                         <th class="text-center">Status</th>
                         <th class="text-center">Opsi</th>
                     </tr>
                 </thead>
                 <tbody>
                     <!-- LOOPING DATA DI SINI -->
                 </tbody>
             </table>
         </div>



     </div>