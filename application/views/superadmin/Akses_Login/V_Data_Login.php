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
                                                 <h4 class="mb-1">Data Akses Login</h4>
                                             </div>

                                             <!-- Aksi untuk Desktop -->
                                             <div class="d-none d-md-flex flex-wrap align-items-center gap-2">

                                                 <a href="<?= base_url('superadmin/Akses_Login/C_Tambah_Akses_Login') ?>" class="btn btn-primary">
                                                     <i class="bi bi-plus-lg me-1"></i> Tambah
                                                 </a>
                                             </div>

                                             <!-- Aksi untuk Mobile -->
                                             <div class="d-flex d-md-none flex-column gap-2 mt-3 w-100">
                                                 <button type="button" class="btn btn-outline-primary w-100 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                     <i class="bi bi-box-arrow-down me-1"></i> Export & Import
                                                 </button>

                                                 <a href="<?= base_url('superadmin/Akses_Login/C_Tambah_Akses_Login') ?>" class="btn btn-primary w-100">
                                                     <i class="bi bi-plus-lg me-1"></i> Tambah
                                                 </a>
                                             </div>

                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <?php if ($this->session->flashdata('tambah_success')): ?>
                                 <div class="alert alert-success text-dark alert-dismissible fade show text-center" role="alert">
                                     <?= $this->session->flashdata('tambah_success'); ?>
                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                 </div>
                             <?php endif; ?>

                             <!-- Tabel -->
                             <table id="mytable" class="table  table-striped table-bordered responsive nowrap" style="width:100%">
                                 <thead class="table-light">
                                     <tr>
                                         <th class="text-center">No</th>
                                         <th class="text-center">Email Login</th>
                                         <th class="text-center">Password Login</th>
                                         <th class="text-center">Akses</th>
                                         <th class="text-center">CLuster</th>
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