<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Edit Akses Login</h3>
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

                <?php foreach ($Data_Login as $data) : ?>
                    <form method="POST" action="<?php echo base_url('superadmin/Akses_Login/C_Edit_Akses_Login/Edit_Save') ?>">
                        <div class="row g-4">

                            <input type="hidden" class="form-control" name="id_login" value="<?php echo $data['id_login'] ?>" placeholder="Masukkan email..." readonly>

                            <!-- Email Login -->
                            <div class="col-md-6">
                                <label for="email_login" class="form-label fw-bold fs-6">Email Login: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope-fill"></i></span> <!-- Ikon email -->
                                    <input type="email" class="form-control" name="email_login" value="<?php echo $data['email_login'] ?>" placeholder="Masukkan email..." required>
                                </div>
                            </div>

                            <!-- Password Login -->
                            <div class="col-md-6">
                                <label for="password_login" class="form-label fw-bold fs-6">Password Login: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-lock-fill"></i></span> <!-- Ikon password -->
                                    <input type="text" class="form-control" name="password_login" value="<?php echo $data['password_login'] ?>" placeholder="Masukkan password..." required>
                                </div>
                            </div>

                            <!-- Tipe Akses -->
                            <div class="col-md-6">
                                <label for="id_akses" class="form-label fw-bold fs-6">Tipe Akses: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-shield-lock-fill"></i></span> <!-- Ikon akses -->
                                    <select id="id_akses" name="id_akses" class="form-control fw-bold" required>
                                        <option value="">Pilih Divisi:</option>
                                        <?php foreach ($Data_Akses as $dataAkses) : ?>
                                            <option value="<?php echo $dataAkses['id_akses'] ?>" <?= $data['id_akses'] == $dataAkses['id_akses'] ? "selected" : null ?>>
                                                <?php echo $dataAkses['nama_akses'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Cluster -->
                            <div class="col-md-6">
                                <label for="cluster" class="form-label fw-bold fs-6">Cluster: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-diagram-3-fill"></i></span> <!-- Ikon email -->
                                    <input type="cluster" class="form-control" name="cluster" value="<?php echo $data['cluster'] ?>" readonly>
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