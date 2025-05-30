<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Edit Data Sales / Penagih</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">

                <?php foreach ($Data_Sales as $data) : ?>
                    <form method="POST" action="<?php echo base_url('admin/Data_Sales/C_Edit_Sales/Edit_Save') ?>">
                        <div class="row g-4">

                            <!-- Hidden Values -->
                            <input type="hidden" name="id_sales" value="<?php echo $data['id_sales'] ?>" readonly>

                            <!-- Nama Sales -->
                            <div class="col-md-6">
                                <label for="nama_pegawai" class="form-label fw-bold fs-6">
                                    Nama Sales / Penagih: <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input type="text" id="nama_pegawai" class="form-control" name="nama_pegawai"
                                        value="<?php echo $data['nama_sales'] ?>" placeholder="Masukkan Nama Sales..." required>
                                </div>
                            </div>

                            <!-- phone sales -->
                            <div class="col-md-6">
                                <label for="phone_sales" class="form-label fw-bold fs-6">Telepon Sales / Penagih: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="number" class="form-control" name="phone_sales" value="<?php echo $data['phone_sales'] ?>" placeholder="Masukkan Nama Sales / Penagih..." required>
                                </div>
                            </div>

                            <!-- Nama Sales -->
                            <div class="col-md-6">
                                <label for="id_jabatan" class="form-label fw-bold fs-6">Nama Divisi: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-file-earmark-text-fill"></i></span>
                                    <select id="id_jabatan" name="id_jabatan" class="form-control" required>
                                        <option value="">Pilih Divisi:</option>
                                        <?php foreach ($Data_Divisi as $dataJabatan) : ?>
                                            <option value="<?php echo $dataJabatan['id_jabatan'] ?>" <?= $data['nama_jabatan'] == $dataJabatan['nama_jabatan'] ? "selected" : null ?>>
                                                <?php echo $dataJabatan['nama_jabatan'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
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