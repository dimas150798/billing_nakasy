     <!-- Content wrapper -->
     <div class="content-wrapper bg-light min-vh-100 py-4">

         <!-- Content -->
         <div class="container-xxl flex-grow-1 container-p-y">
             <div class="row">
                 <div class="col-12">
                     <div class="card mb-3">

                         <div class="card-body">

                             <!-- Header -->
                             <div class="row">
                                 <div class="col-12">
                                     <div class="p-4 bg-white shadow-sm rounded-4 mb-4 border border-0">

                                         <!-- Judul -->
                                         <div class="mb-4">
                                             <h4 class="fw-bold text-dark mb-2">Status Pembayaran : <span class="text-danger">Belum Lunas</span></h4>
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

                             <!-- Table -->
                             <div class="table-responsive">
                                 <table id="mytable" class="table table-hover table-striped table-bordered align-middle responsive nowrap" style="width:100%">
                                     <thead class="table-light">
                                         <tr>
                                             <th class="text-center">No</th>
                                             <th class="text-center">Nama Customer</th>
                                             <th class="text-center">Name PPPOE</th>
                                             <th class="text-center">Nama Paket</th>
                                             <th class="text-center">Harga</th>
                                             <th class="text-center">Status</th>
                                             <th class="text-center">Action</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                     </tbody>
                                 </table>
                             </div>
                         </div>


                     </div>
                 </div>
             </div>
         </div>

     </div>