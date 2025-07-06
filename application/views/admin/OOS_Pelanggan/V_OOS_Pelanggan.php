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
                             <span class="fw-semibold mb-0">Data Pelanggan Gangguan :</span>
                         </div>

                         <!-- Info Jumlah dan Nominal -->
                         <div class="d-flex flex-wrap gap-3">
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bi bi-people-fill fs-5 text-primary"></i>
                                 <span class="fw-semibold">Gangguan All :</span>
                                 <span class="badge bg-primary text-white fs-6 px-3 py-2 rounded-pill"><?= $Jumlah_OOS_All ?></span>
                             </div>
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bi bi-calendar-day-fill fs-5 text-info"></i>
                                 <span class="fw-semibold">Gangguan Hari Ini :</span>
                                 <span class="badge bg-info text-white fs-6 px-3 py-2 rounded-pill"><?= $Jumlah_OOS_Today ?></span>
                             </div>
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bi bi-calendar-week-fill fs-5 text-success"></i>
                                 <span class="fw-semibold">Gangguan 1 Minggu :</span>
                                 <span class="badge bg-success text-white fs-6 px-3 py-2 rounded-pill"><?= $Jumlah_OOS_LastWeek ?></span>
                             </div>
                             <div class="d-flex align-items-center gap-2">
                                 <i class="bi bi-calendar-month-fill fs-5 text-warning"></i>
                                 <span class="fw-semibold">Gangguan 1 Bulan :</span>
                                 <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill"><?= $Jumlah_OOS_OneMonth ?></span>
                             </div>
                         </div>

                     </div>

                 </div>
             </div>

         </div>

         <!-- Table -->
         <div class="table-responsive" style="width: 100%;">
             <table id="mytable" class="table table-striped table-bordered w-100 responsive">
                 <thead class="table-light">
                     <tr>
                         <th class="text-center">No</th>
                         <th class="text-center">Tiket</th>
                         <th class="text-center">Nama</th>
                         <th class="text-center">ID</th>
                         <th class="text-center">Paket</th>
                         <th class="text-center">Tanggal</th>
                         <th class="text-center">Jumlah Gangguan</th>
                         <th class="text-center">Status</th>
                     </tr>
                 </thead>
                 <tbody>
                     <!-- LOOPING DATA DI SINI -->
                 </tbody>
             </table>
         </div>

     </div>