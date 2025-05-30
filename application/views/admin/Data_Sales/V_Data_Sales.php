<!-- Content Wrapper -->
<div class="content-wrapper bg-light min-vh-100 py-4">

    <!-- Container -->
    <div class="container-xxl flex-grow-1">

        <!-- Card -->
        <div class="card shadow-sm border-0 mb-4">

            <!-- Header -->
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 text-primary fw-bold">
                    <i class="menu-icon tf-icons bx bx-user-voice"></i> Data Sales / Penagih
                </h3>

                <!-- Aksi (Desktop + Mobile) -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <!-- Aksi untuk Desktop -->
                    <div class="d-none d-md-flex">
                        <a href="<?= base_url('admin/Data_Sales/C_Tambah_Sales') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah
                        </a>
                    </div>

                    <!-- Aksi untuk Mobile -->
                    <div class="d-md-none">
                        <a href="<?= base_url('admin/Data_Sales/C_Tambah_Sales') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">

                <!-- Table -->
                <div class="table-responsive">
                    <table id="mytable" class="table table-hover table-striped table-bordered align-middle" style="width:100%">
                        <thead class="table-light">
                            <tr class="text-center text-nowrap">
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Sales</th>
                                <th class="text-center">Telepon Sales</th>
                                <th class="text-center">Nama Jabatan</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data Tabel Akan Dimasukkan di sini -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>