<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Edit Pelanggan</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">

                <?php foreach ($Data_Pelanggan as $data) : ?>
                    <form method="POST" action="<?php echo base_url('admin/Data_Pelanggan/C_Edit_Pelanggan/Edit_PelangganSave') ?>">
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
                                    <input type="text" class="form-control" name="nama_customer" value="<?php echo $data['nama_customer'] ?>" placeholder="Masukkan Nama Pelanggan..." required>
                                </div>
                            </div>

                            <!-- Tanggal Registrasi -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold fs-6">Tanggal Registrasi: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-date"></i></span>
                                    <input type="date" class="form-control" name="start_date" value="<?php echo $data['start_date'] ?>" required>
                                </div>
                            </div>

                            <!-- Kode Pelanggan -->
                            <div class="col-md-6">
                                <label for="kode_customer" class="form-label fw-bold fs-6">Kode Pelanggan: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" class="form-control" name="kode_customer" value="<?php echo $data['kode_customer'] ?>" placeholder="Masukkan Kode Pelanggan..." required>
                                </div>
                            </div>

                            <!-- Name PPPOE -->
                            <div class="col-md-6">
                                <label for="name_pppoe" class="form-label fw-bold fs-6">Name PPPOE: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-bounding-box"></i></span>
                                    <input type="text" class="form-control" name="name_pppoe" value="<?php echo $data['name_pppoe'] ?>" placeholder="Masukkan Name PPPOE..." required>
                                </div>
                            </div>

                            <!-- Password PPPOE -->
                            <div class="col-md-6">
                                <label for="password_pppoe" class="form-label fw-bold fs-6">Password PPPOE: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-shield-lock"></i></span>
                                    <input type="text" class="form-control" name="password_pppoe" value="<?php echo $data['password_pppoe'] ?>" placeholder="Masukkan Password PPPOE..." required>
                                </div>
                            </div>

                            <!-- Phone Customer -->
                            <div class="col-md-6">
                                <label for="phone_customer" class="form-label fw-bold fs-6">No. Telepon: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="text" class="form-control" name="phone_customer" value="<?php echo $data['phone_customer'] ?>" placeholder="Masukkan No Telepon..." required>
                                </div>
                            </div>

                            <!-- Paket Internet -->
                            <div class="col-md-6">
                                <label for="id_paket" class="form-label fw-bold fs-6">Paket Internet: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-wifi"></i></span>
                                    <select id="nama_paket" name="nama_paket" class="form-control" required>
                                        <option value="">Pilih Paket:</option>
                                        <?php foreach ($DataPaket as $dataPaket) : ?>
                                            <option value="<?php echo $dataPaket['id_paket'] ?>" <?= $data['nama_paket'] == $dataPaket['nama_paket'] ? "selected" : null ?>>
                                                <?php echo $dataPaket['nama_paket'] ?> / <?php echo $dataPaket['harga_paket']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Nama Area -->
                            <div class="col-md-6">
                                <label for="id_area" class="form-label fw-bold fs-6">Nama ODP / Area: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-map"></i></span>
                                    <select id="nama_area" name="nama_area" class="form-control" required>
                                        <option value="">Pilih Area:</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['nama_area'] ?>" <?= $data['nama_area'] == $dataArea['nama_area'] ? "selected" : null ?>>
                                                <?php echo $dataArea['nama_area'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Nama Sales -->
                            <div class="col-md-6">
                                <label for="id_sales" class="form-label fw-bold fs-6">Nama Sales / Penagih: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-check-fill"></i></span>
                                    <select id="nama_sales" name="nama_sales" class="form-control" required>
                                        <option value="">Pilih Sales:</option>
                                        <?php foreach ($DataSales as $dataSales) : ?>
                                            <option value="<?php echo $dataSales['nama_sales'] ?>" <?= $data['nama_sales'] == $dataSales['nama_sales'] ? "selected" : null ?>>
                                                <?php echo $dataSales['nama_sales'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Email Pelanggan -->
                            <div class="col-md-6">
                                <label for="email_customer" class="form-label fw-bold fs-6">Email Pelanggan: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="text" class="form-control" name="email_customer" value="<?php echo $data['email_customer'] ?>" placeholder="Masukkan Email Pelanggan..." required>
                                </div>
                            </div>

                            <!-- Alamat Pelanggan -->
                            <div class="col-md-6">
                                <label for="alamat_customer" class="form-label fw-bold fs-6">Alamat Pelanggan: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-house-door-fill"></i></span>
                                    <textarea class="form-control" name="alamat_customer" id="alamat_customer" rows="3" placeholder="Masukkan Alamat Pelanggan..." required><?php echo $data['alamat_customer'] ?></textarea>
                                </div>
                            </div>

                            <!-- Deskripsi Pelanggan -->
                            <div class="col-md-6">
                                <label for="deskripsi_customer" class="form-label fw-bold fs-6">Keterangan: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-file-earmark-text-fill"></i></span>
                                    <textarea class="form-control" name="deskripsi_customer" id="deskripsi_customer" rows="3" placeholder="Masukkan Keterangan..." required><?php echo $data['deskripsi_customer'] ?></textarea>
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