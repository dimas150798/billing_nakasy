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
                                     <div class="p-3 bg-white shadow-sm rounded mb-3 border">
                                         <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                             <!-- Judul dan Informasi -->
                                             <div class="mb-3 mb-md-0">
                                                 <h3 class="mb-1">Data Pelanggan</h3>
                                                 <div class="small text-muted">
                                                     Total Pelanggan :
                                                     <span class="badge bg-primary"><?php echo $Total_Pelanggan ?></span>
                                                     <span class="mx-1 d-none d-md-inline">|</span>
                                                     <br class="d-md-none">
                                                     Cluster :
                                                     <span class="badge bg-success"><?= $this->session->userdata('cluster') ?></span>
                                                 </div>
                                             </div>

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
                                                     <i class="bi bi-plus-lg me-1"></i> Tambah
                                                 </a>
                                             </div>

                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <?php if ($this->session->flashdata('registrasi_success')): ?>
                                 <div class="alert alert-success text-dark alert-dismissible fade show text-center" role="alert">
                                     <?= $this->session->flashdata('registrasi_success'); ?>
                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                 </div>
                             <?php endif; ?>

                             <!-- Tabel -->
                             <table id="mytable" class="table  table-striped table-bordered responsive nowrap" style="width:100%">
                                 <thead class="table-light">
                                     <tr>
                                         <th class="text-center">No</th>
                                         <th class="text-center">Nama Customer</th>
                                         <th class="text-center">Name PPPOE</th>
                                         <th class="text-center">Telepon</th>
                                         <th class="text-center">Nama Paket</th>
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