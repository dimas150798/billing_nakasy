<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Tambah Pelanggan</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">
                <?php if ($this->session->flashdata('duplicate_name')): ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <?= $this->session->flashdata('duplicate_name'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo base_url('admin/Data_Pelanggan/C_Tambah_Pelanggan/TambahPelangganSave') ?>">

                    <div class="row g-4">
                        <!-- Hidden Input for Order ID -->
                        <input type="hidden" class="form-control fw-bold" name="order_id" id="order_id" value="<?php echo $this->M_BelumLunas->invoice() ?>" readonly>

                        <!-- Nama Pelanggan -->
                        <div class="col-md-6">
                            <label for="nama_customer" class="form-label fw-bold fs-6"> Nama Pelanggan: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control fw-bold" name="nama_customer" id="nama_customer" value="" placeholder="Masukkan Nama pelanggan..." required>
                            </div>
                        </div>

                        <!-- Tanggal Registrasi -->
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-bold fs-6"> Tanggal Registrasi: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" class="form-control fw-bold" name="start_date" id="start_date" value="" required>
                            </div>
                        </div>

                        <!-- Kode Pelanggan -->
                        <div class="col-md-6">
                            <label for="kode_customer" class="form-label fw-bold fs-6"> Kode Pelanggan: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-upc-scan"></i></span>
                                <input type="text" class="form-control fw-bold" name="kode_customer" id="kode_customer" value="" placeholder="Masukkan Kode Pelanggan..." required>
                            </div>
                        </div>

                        <!-- Name PPPOE -->
                        <div class="col-md-6">
                            <label for="name_pppoe" class="form-label fw-bold fs-6"> Name PPPOE: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-person-bounding-box"></i></span>
                                <input type="text" class="form-control fw-bold" name="name_pppoe" id="name_pppoe" value="" placeholder="Masukkan Name PPPOE..." required>
                            </div>
                        </div>

                        <!-- Password PPPOE -->
                        <div class="col-md-6">
                            <label for="password_pppoe" class="form-label fw-bold fs-6"> Password PPPOE: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-shield-lock"></i></span>
                                <input type="text" class="form-control fw-bold" name="password_pppoe" id="password_pppoe" value="" placeholder="Masukkan Password PPPOE..." required>
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-md-6">
                            <label for="phone_customer" class="form-label fw-bold fs-6"> No. Telepon: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" class="form-control fw-bold" name="phone_customer" id="phone_customer" value="" placeholder="Masukkan No Telepon..." required>
                            </div>
                        </div>

                        <!-- Paket Internet -->
                        <div class="col-md-6">
                            <label for="id_paket" class="form-label fw-bold fs-6"> Paket Internet: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-wifi"></i></span>
                                <select id="nama_paket" name="id_paket" class="form-control fw-bold" required>
                                    <option value="">Pilih Paket:</option>
                                    <?php foreach ($DataPaket as $dataPaket) : ?>
                                        <option value="<?php echo $dataPaket['id_paket']; ?>">
                                            <?php echo $dataPaket['nama_paket']; ?> / <?php echo $dataPaket['harga_paket']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- ODP Area -->
                        <div class="col-md-6">
                            <label for="nama_area" class="form-label fw-bold fs-6"> ODP Area: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-map"></i></span>
                                <select id="nama_area" name="nama_area" class="form-control fw-bold" required>
                                    <option value="">Pilih Area:</option>
                                    <?php foreach ($DataArea as $dataArea) : ?>
                                        <option value="<?php echo $dataArea['nama_area']; ?>">
                                            <?php echo $dataArea['nama_area']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Sales -->
                        <div class="col-md-6">
                            <label for="nama_sales" class="form-label fw-bold fs-6"> Sales: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-person-check-fill"></i></span>
                                <select id="nama_sales" name="nama_sales" class="form-control fw-bold" required>
                                    <option value="">Pilih Sales:</option>
                                    <?php foreach ($DataSales as $dataSales) : ?>
                                        <option value="<?php echo $dataSales['nama_sales']; ?>">
                                            <?php echo $dataSales['nama_sales']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Email Pelanggan -->
                        <div class="col-md-6">
                            <label for="email_customer" class="form-label fw-bold fs-6"> Email Pelanggan:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope-at-fill"></i></span>
                                <input type="text" class="form-control fw-bold" name="email_customer" id="email_customer" value="" placeholder="Masukkan Email Pelanggan..." required>
                            </div>
                        </div>

                        <!-- Alamat Pelanggan -->
                        <div class="col-md-6">
                            <label for="alamat_customer" class="form-label fw-bold fs-6"> Alamat Pelanggan: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-house-door-fill"></i></span>
                                <textarea class="form-control fw-bold" name="alamat_customer" id="alamat_customer" cols="10" rows="3" placeholder="Masukkan Alamat Pelanggan..." required></textarea>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-md-6">
                            <label for="deskripsi_customer" class="form-label fw-bold fs-6"> Keterangan: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-file-earmark-text-fill"></i></span>
                                <textarea class="form-control fw-bold" name="deskripsi_customer" id="deskripsi_customer" cols="10" rows="3" placeholder="Masukkan Keterangan..." required></textarea>
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

    <div class="content-backdrop fade"></div>
</div>