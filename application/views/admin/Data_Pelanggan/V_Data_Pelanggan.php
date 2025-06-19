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
                             <span class="fw-semibold mb-0">Data Pelanggan :</span>
                         </div>

                         <!-- Info Jumlah dan Nominal -->
                         <div class="d-flex flex-wrap gap-3">
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bx bx-user fs-5 text-primary"></i>
                                 <span class="fw-semibold">Jumlah :</span>
                                 <span class="badge bg-primary text-white fs-6 px-3 py-2 rounded-pill"><?= $Total_Pelanggan ?></span>
                             </div>
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bi bi-person-check-fill fs-5 text-success"></i>
                                 <span class="fw-semibold">Pelangan Enable :</span>
                                 <span class="badge bg-success text-white fs-6 px-3 py-2 rounded-pill"><?= $Pelanggan_Enable ?></span>
                             </div>
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bi bi-person-x-fill fs-5 text-danger"></i>
                                 <span class="fw-semibold">Pelangan Disabled :</span>
                                 <span class="badge bg-danger text-white fs-6 px-3 py-2 rounded-pill"><?= $Pelanggan_Disable ?></span>
                             </div>
                         </div>
                     </div>


                     <!-- Filter -->
                     <!-- Aksi untuk Desktop -->
                     <div class="d-none d-md-flex flex-wrap align-items-center gap-2">
                         <div class="btn-group">
                             <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="bi bi-box-arrow-down me-1"></i> Export & Import
                             </button>
                             <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">Export as Excel</a></li>
                                 <li><a class="dropdown-item" href="<?= base_url('admin/Data_Pelanggan/C_Import_Pelanggan') ?>">Import as Excel</a></li>
                             </ul>
                         </div>
                         <a href="<?= base_url('admin/Data_Pelanggan/C_Tambah_Pelanggan') ?>" class="btn btn-primary">
                             <i class="bi bi-plus-lg me-1"></i> Tambah
                         </a>
                     </div>

                     <!-- Aksi untuk Mobile -->
                     <div class="d-flex d-md-none flex-column gap-2 mt-3 w-100">
                         <button type="button" class="btn btn-outline-primary w-100 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="bi bi-box-arrow-down me-1"></i> Export & Import
                         </button>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="#">Export as Excel</a></li>
                             <li><a class="dropdown-item" href="<?= base_url('admin/Data_Pelanggan/C_Import_Pelanggan') ?>">Import as Excel</a></li>
                         </ul>

                         <a href="<?= base_url('admin/Data_Pelanggan/C_Tambah_Pelanggan') ?>" class="btn btn-primary w-100">
                             <i class="bi bi-person-plus me-1"></i> Tambah
                         </a>
                     </div>
                 </div>
             </div>

         </div>

         <!-- Alert -->
         <?php if ($this->session->flashdata('registrasi_success')): ?>
             <div class="alert alert-success text-dark alert-dismissible fade show text-center" role="alert">
                 <?= $this->session->flashdata('registrasi_success'); ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
         <?php endif; ?>

         <!-- Table -->
         <div class="table-responsive" style="width: 100%;">
             <table id="mytable" class="table table-striped table-bordered w-100 responsive">
                 <thead class="table-light">
                     <tr>
                         <th class="text-center">No</th>
                         <th class="text-center">Nama</th>
                         <th class="text-center">ID</th>
                         <th class="text-center">Paket</th>
                         <th class="text-center">Telepon</th>
                         <th class="text-center">Alamat</th>
                         <th class="text-center">Area</th>
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