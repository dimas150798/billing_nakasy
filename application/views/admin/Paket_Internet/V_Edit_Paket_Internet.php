<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Edit Paket Internet</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">

                <?php foreach ($Paket_Internet as $data) : ?>
                    <form method="POST" action="<?php echo base_url('admin/Paket_Internet/C_Edit_Paket_Internet/Edit_Save') ?>">
                        <div class="row g-4">

                            <!-- Hidden Values -->
                            <input type="hidden" name="id_paket" value="<?php echo $data['id_paket'] ?>" readonly>

                            <!-- Nama Paket -->
                            <div class="col-md-6">
                                <label for="nama_paket" class="form-label fw-bold fs-6">
                                    Nama Paket Internet: <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="bi bi-wifi"></i>
                                    </span>
                                    <input type="text" id="nama_paket" class="form-control" name="nama_paket"
                                        value="<?php echo $data['nama_paket'] ?>" placeholder="Masukkan Nama Paket..." readonly>
                                </div>
                            </div>

                            <!-- Harga Paket -->
                            <div class="col-md-6">
                                <label for="harga_paket" class="form-label fw-bold fs-6">
                                    Harga Paket: <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="bi bi-cash-stack"></i> <!-- Ganti ikon agar lebih sesuai -->
                                    </span>
                                    <input type="number" id="harga_paket" class="form-control" name="harga_paket"
                                        value="<?php echo $data['harga_paket'] ?>" placeholder="Masukkan Harga Paket..." required>
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