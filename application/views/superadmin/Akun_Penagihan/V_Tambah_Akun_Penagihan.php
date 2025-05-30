<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">

            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Tambah Akun Penagihan</h3>
                        <div class="text-secondary fw-semibold text-muted fst-italic mt-1" style="font-size: 1rem;">
                            Masukkan area sesuai kebutuhan atau sesuai area akun penagihan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">
                <?php if ($this->session->flashdata('duplicate_email')): ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <?= $this->session->flashdata('duplicate_email'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo base_url('superadmin/Akun_Penagihan/C_Tambah_Akun_Penagihan/TambahAkunPenagihanSave') ?>">
                    <div class="row g-4">

                        <!-- Email Login -->
                        <div class="col-md-6">
                            <label for="email_login_akun" class="form-label fw-bold fs-6">Email Login: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope-fill"></i></span> <!-- Ikon akses -->
                                <select id="email_login_akun" name="email_login_akun" class="form-control fw-bold" required>
                                    <option value="">Pilih Divisi:</option>
                                    <?php foreach ($Data_Login as $data) : ?>
                                        <option value="<?php echo $data['email_login']; ?>">
                                            <?php echo $data['email_login']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Nama Penagihan -->
                        <div class="col-md-6">
                            <label for="nama_penagihan" class="form-label fw-bold fs-6">Nama: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" name="nama_penagihan" value="" placeholder="Masukkan nama..." required>
                            </div>
                        </div>

                        <!-- Area 1-->
                        <div class="col-md-6">
                            <label for="area_1" class="form-label fw-bold fs-6">Area Pertama: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-map"></i></span>
                                <select id="area_1" name="area_1" class="form-control fw-bold" required>
                                    <option value="">Pilih Area:</option>
                                    <?php foreach ($DataArea as $dataArea) : ?>
                                        <option value="<?php echo $dataArea['nama_area']; ?>">
                                            <?php echo $dataArea['nama_area']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Area 2-->
                        <div class="col-md-6">
                            <label for="area_2" class="form-label fw-bold fs-6">Area Kedua: </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-map"></i></span>
                                <select id="area_2" name="area_2" class="form-control fw-bold">
                                    <option value="">Pilih Area:</option>
                                    <?php foreach ($DataArea as $dataArea) : ?>
                                        <option value="<?php echo $dataArea['nama_area']; ?>">
                                            <?php echo $dataArea['nama_area']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Area 3-->
                        <div class="col-md-6">
                            <label for="area_3" class="form-label fw-bold fs-6">Area Ketiga: </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-map"></i></span>
                                <select id="area_3" name="area_3" class="form-control fw-bold">
                                    <option value="">Pilih Area:</option>
                                    <?php foreach ($DataArea as $dataArea) : ?>
                                        <option value="<?php echo $dataArea['nama_area']; ?>">
                                            <?php echo $dataArea['nama_area']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Area 4 -->
                        <div class="col-md-6">
                            <label for="area_4" class="form-label fw-bold fs-6">Area Keempat: </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-map"></i></span>
                                <select id="area_4" name="area_4" class="form-control fw-bold">
                                    <option value="">Pilih Area:</option>
                                    <?php foreach ($DataArea as $dataArea) : ?>
                                        <option value="<?php echo $dataArea['nama_area']; ?>">
                                            <?php echo $dataArea['nama_area']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Area 5 -->
                        <div class="col-md-6">
                            <label for="area_5" class="form-label fw-bold fs-6">Area Kelima: </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-map"></i></span>
                                <select id="area_5" name="area_5" class="form-control fw-bold">
                                    <option value="">Pilih Area:</option>
                                    <?php foreach ($DataArea as $dataArea) : ?>
                                        <option value="<?php echo $dataArea['nama_area']; ?>">
                                            <?php echo $dataArea['nama_area']; ?>
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

            </div>
            <!-- /Account -->
        </div>
    </div>
    <!-- / Content -->
</div>