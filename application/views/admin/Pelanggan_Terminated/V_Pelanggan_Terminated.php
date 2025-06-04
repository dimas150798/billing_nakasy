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
                                                 <h3 class="mb-1">Data Pelanggan Terminated</h3>
                                                 <div class="small text-muted">
                                                     Total Pelanggan :
                                                     <span class="badge bg-primary"><?php echo $Total_Pelanggan ?></span>
                                                     <span class="mx-1 d-none d-md-inline">|</span>
                                                     <br class="d-md-none">
                                                     Cluster :
                                                     <span class="badge bg-success"><?= $this->session->userdata('cluster') ?></span>
                                                 </div>
                                             </div>

                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <?php if ($this->session->flashdata('aktif_pelanggan')): ?>
                                 <div class="alert alert-success text-dark alert-dismissible fade show text-center" role="alert">
                                     <?= $this->session->flashdata('aktif_pelanggan'); ?>
                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                 </div>
                             <?php endif; ?>

                             <!-- Tabel -->
                             <table id="mytable" class="table  table-striped table-bordered responsive nowrap" style="width:100%">
                                 <thead class="table-light">
                                     <tr>
                                         <th class="text-center">No</th>
                                         <th>Nama Customer</th>
                                         <th>Name PPPOE</th>
                                         <th>Nama Paket</th>
                                         <th>Status</th>
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