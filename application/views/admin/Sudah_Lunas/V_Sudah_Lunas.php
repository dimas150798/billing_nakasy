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
                             <span class="badge bg-success text-white fs-6 px-3 py-2 rounded-pill">Sudah Lunas</span>
                         </div>

                         <!-- Info Jumlah dan Nominal -->
                         <div class="d-flex flex-wrap gap-3">
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bx bx-user fs-5 text-primary"></i>
                                 <span class="fw-semibold">Jumlah :</span>
                                 <span class="badge bg-primary text-white fs-6 px-3 py-2 rounded-pill"><?= $Jumlah_SudahLunas ?></span>
                             </div>
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bx bx-money fs-5 text-success"></i>
                                 <span class="fw-semibold">Nominal :</span>
                                 <span class="badge bg-success text-white fs-6 px-3 py-2 rounded-pill"><?= number_format($Nominal_SudahLunas, 0, ',', '.') ?></span>
                             </div>
                         </div>
                     </div>


                     <!-- Filter -->
                     <form class="row row-cols-1 row-cols-md-auto g-3 align-items-end" action="<?= base_url('admin/Sudah_Lunas/C_Sudah_Lunas') ?>" method="get">
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
             <?php if ($this->session->flashdata('edit_success')): ?>
                 <div class="alert alert-success text-dark alert-dismissible fade show text-center" role="alert">
                     <?= $this->session->flashdata('edit_success'); ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
             <?php endif; ?>
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
                         <th class="text-center">Keterangan</th>
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