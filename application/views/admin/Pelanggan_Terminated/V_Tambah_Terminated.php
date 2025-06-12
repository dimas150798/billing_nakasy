<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Terminated Pelanggan</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">

                <?php foreach ($Data_Pelanggan as $data) : ?>
                    <form method="POST" action="<?php echo base_url('admin/Pelanggan_Terminated/C_Tambah_Terminated/Terminated_PelangganSave') ?>">
                        <div class="row g-4">

                            <!-- Hidden Values -->
                            <input type="hidden" name="id_customer" value="<?php echo $data['id_customer'] ?>" readonly>
                            <input type="hidden" name="id_pppoe" value="<?php echo $data['id_pppoe'] ?>" readonly>
                            <input type="hidden" name="kode_mikrotik" value="<?php echo $data['kode_mikrotik'] ?>" readonly>
                            <input type="hidden" name="name_pppoe_session" value="<?php echo $data['name_pppoe'] ?>" readonly>

                            <!-- Nama Pelanggan -->
                            <div class="col-md-6">
                                <label for="nama_customer" class="form-label fw-bold fs-6">Nama Pelanggan: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" name="nama_customer" value="<?php echo $data['nama_customer'] ?>" placeholder="Masukkan Nama Pelanggan..." readonly>
                                </div>
                            </div>

                            <!-- Name PPPOE -->
                            <div class="col-md-6">
                                <label for="name_pppoe" class="form-label fw-bold fs-6">Name PPPOE: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-bounding-box"></i></span>
                                    <input type="text" class="form-control" name="name_pppoe" value="<?php echo $data['name_pppoe'] ?>" placeholder="Masukkan Name PPPOE..." readonly>
                                </div>
                            </div>

                            <!-- Tanggal Terminated -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold fs-6">Tanggal Terminated: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-date"></i></span>
                                    <input type="date" class="form-control" name="stop_date" value="" required>
                                </div>
                            </div>

                        </div>

                        <!-- Button -->
                        <div class="mt-6 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">Simpan</button>
                            <button type="reset" class="btn btn-outline-secondary">Batal</button>
                        </div>

                    </form>
                <?php endforeach; ?>

            </div>
            <!-- /Account -->
        </div>
    </div>
    <!-- / Content -->
</div>