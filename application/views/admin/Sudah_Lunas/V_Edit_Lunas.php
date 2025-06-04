<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="card mb-6 shadow-lg border-0 rounded-3">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between pb-4 border-bottom">
                    <div class="button-wrapper">
                        <h3 class="mb-0 text-primary fw-bold">Edit Pembayaran Pelanggan</h3>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">
                <?php if ($this->session->flashdata('duplicate_transaksi')): ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <?= $this->session->flashdata('duplicate_transaksi'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php foreach ($Data_Pelanggan as $data) : ?>
                    <form method="POST" action="<?php echo base_url('admin/Sudah_Lunas/C_Edit_Lunas/Edit_LunasSave') ?>">
                        <div class="row g-4">

                            <!-- Hidden Values -->
                            <input type="hidden" name="id_pppoe" value="<?= $data['id_pppoe'] ?>" readonly>
                            <input type="hidden" name="id_customer" value="<?= $data['id_customer'] ?>" readonly>
                            <input type="hidden" name="order_id" value="<?php echo $this->M_BelumLunas->invoice() ?>" readonly>
                            <input type="hidden" name="gross_amount" value="<?= $data['harga_paket'] ?>" readonly>
                            <input type="hidden" name="order_id" value="<?= $data['order_id'] ?>" readonly>

                            <!-- Nama Pelanggan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Nama Pelanggan: </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-circle"></i></span>
                                    <input type="text" class="form-control" name="nama_customer" value="<?= ucwords(strtolower($data['nama_customer'])) ?>" readonly>
                                </div>
                            </div>

                            <!-- Name PPPOE -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Name PPPOE: </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-badge-fill"></i></span>
                                    <input type="text" class="form-control" name="name_pppoe" value="<?= $data['name_pppoe'] ?>" readonly>
                                </div>
                            </div>

                            <!-- Nama Paket -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Nama Paket: </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-wifi"></i></span>
                                    <input type="text" class="form-control" name="nama_paket" value="<?= $data['nama_paket'] ?>" readonly>
                                </div>
                            </div>

                            <!-- Nominal Pembayaran -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Nominal Pembayaran: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-currency-dollar"></i></span>
                                    <input type="text" class="form-control" id="rupiahDisplay" value="<?= $data['gross_amount'] ?>" placeholder="Masukkan nominal pembayaran..." required>
                                    <input type="hidden" name="gross_amount" id="rupiahRaw">
                                </div>
                            </div>

                            <!-- Tanggal Pembayaran -->
                            <div class="col-md-6">
                                <label for="transaction_time" class="form-label fw-bold fs-6">Tanggal Pembayaran: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-event-fill"></i></span>
                                    <input type="datetime-local" class="form-control fw-bold" name="transaction_time" id="transaction_time" value="<?= $data['transaction_time'] ?>" required>
                                </div>
                            </div>

                            <!-- Pembayaran Melalui -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Pembayaran Melalui: </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-check-fill"></i></span>
                                    <input type="text" class="form-control" name="nama_sales" value="<?= $data['nama_admin'] ?>" placeholder="Masukkan pembayaran melalui..." required>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="col-md-6">
                                <label for="keterangan" class="form-label fw-bold fs-6">Keterangan:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-chat-text-fill"></i></span>
                                    <input type="text" class="form-control fw-bold" name="keterangan" id="keterangan" value="<?= $data['keterangan'] ?>" placeholder="Masukkan keterangan...">
                                </div>
                            </div>

                        </div>

                        <!-- Button -->
                        <div class="mt-6 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">Kirim</button>
                        </div>

                    </form>
                <?php endforeach; ?>
            </div>
            <!-- /Account -->
        </div>
    </div>
    <!-- / Content -->
</div>