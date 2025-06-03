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
                                         <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">

                                             <!-- Judul dan Informasi -->
                                             <div>
                                                 <h4 class="mb-2 fw-bold text-dark">Status Pembayaran : <span class="text-success">Sudah Lunas</span></h4>
                                                 <div class="d-flex flex-wrap gap-3 fs-6 text-dark">
                                                     <div>
                                                         <span class="me-2">Jumlah:</span>
                                                         <span class="badge bg-primary text-white px-3 py-2 fs-6 fw-semibold">
                                                             <?= $Jumlah_SudahLunas ?>
                                                         </span>
                                                     </div>
                                                     <div>
                                                         <span class="me-2">Nominal:</span>
                                                         <span class="badge bg-success text-white px-3 py-2 fs-6 fw-semibold">
                                                             <?= number_format($Nominal_SudahLunas, 0, ',', '.') ?>
                                                         </span>
                                                     </div>
                                                 </div>
                                             </div>

                                             <!-- Filter Form -->
                                             <form class="row row-cols-1 row-cols-md-auto g-3 align-items-end" action="<?= base_url('admin/Sudah_Lunas/C_Sudah_Lunas') ?>" method="get">
                                                 <!-- Tahun -->
                                                 <div>
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
                                                 <div>
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
                                                 <div>
                                                     <button type="submit" class="btn btn-outline-info fw-semibold px-4">
                                                         <i class="fas fa-eye me-2"></i> Tampilkan
                                                     </button>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Tabel -->
                             <table id="mytable" class="table  table-striped table-bordered responsive nowrap" style="width:100%">
                                 <thead class="table-light">
                                     <tr>
                                         <th class="text-center">No</th>
                                         <th class="text-center">Nama Customer</th>
                                         <th class="text-center">Name PPPOE</th>
                                         <th class="text-center">Tanggal</th>
                                         <th class="text-center">Nama Paket</th>
                                         <th class="text-center">Harga</th>
                                         <th class="text-center">Melalui</th>
                                         <th class="text-center">Keterangan</th>
                                         <th class="text-center">Status</th>
                                         <th class="text-center">Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <!-- Your table body content goes here -->
                                 </tbody>
                             </table>
                         </div>


                     </div>
                 </div>
             </div>
         </div>

     </div>