<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Edit Data ODP / Area</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">

                <?php foreach ($Data_ODP as $data) : ?>
                    <form method="POST" action="<?php echo base_url('admin/Data_ODP/C_Edit_ODP/Edit_Save') ?>">
                        <div class="row g-4">

                            <!-- Hidden Values -->
                            <input type="hidden" name="id_area" value="<?php echo $data['id_area'] ?>" readonly>

                            <!-- Nama Area -->
                            <div class="col-md-12">
                                <label for="nama_odp" class="form-label fw-bold fs-6">
                                    Nama ODP / Area: <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="bi bi-map"></i>
                                    </span>
                                    <input type="text" id="nama_odp" class="form-control" name="nama_odp"
                                        value="<?php echo $data['nama_area'] ?>" placeholder="Masukkan Nama Area..." required>
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