          <!-- Content wrapper -->
          <div class="content-wrapper">
              <!-- Content -->
              <div class="container-xxl flex-grow-1 container-p-y">
                  <div class="row">
                      <div class="col-md-12">

                          <div class="nav-align-top">
                              <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                                  <li class="nav-item">
                                      <a class="nav-link" href="<?php echo base_url('admin/Belum_Lunas/C_Pembayaran_Perbulan') ?>"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Pembayaran Wifi Bulanan</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Pembayaran Wifi Harian</a>
                                  </li>
                              </ul>
                          </div>

                          <div class="card mb-6">
                              <!-- Account -->
                              <div class="card-body">
                                  <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                                      <h3 class="mb-0 text-primary fw-bold">
                                          <i class="bi bi-wifi me-2"></i> Pembayaran Wifi Perhari
                                      </h3>
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
                                  <form method="POST" action="<?php echo base_url('admin/Belum_Lunas/C_Pembayaran_Perhari/PaymentSave') ?>">
                                      <div class="row g-4">

                                          <!-- Hidden Values -->
                                          <input type="hidden" name="id_pppoe" value="<?= $data['id_pppoe'] ?>" readonly>
                                          <input type="hidden" name="id_customer" value="<?= $data['id_customer'] ?>" readonly>
                                          <input type="hidden" name="order_id" value="<?php echo $this->M_BelumLunas->invoice() ?>" readonly>

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
                                                  <input type="text" class="form-control" id="rupiahDisplay" placeholder="Masukkan nominal pembayaran..." required>
                                                  <input type="hidden" name="gross_amount" id="rupiahRaw">
                                              </div>
                                          </div>

                                          <!-- Tanggal Pembayaran -->
                                          <div class="col-md-6">
                                              <label for="transaction_time" class="form-label fw-bold fs-6">Tanggal Pembayaran: <span class="text-danger">*</span></label>
                                              <div class="input-group">
                                                  <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-event-fill"></i></span>
                                                  <input type="datetime-local" class="form-control fw-bold" name="transaction_time" id="transaction_time" value="" required>
                                              </div>
                                          </div>

                                          <!-- Biaya Admin -->
                                          <div class="col-md-6">
                                              <label class="form-label fw-bold fs-6">Biaya Admin: <span class="text-danger">*</span></label>
                                              <div class="input-group">
                                                  <span class="input-group-text bg-primary text-white"><i class="bi bi-receipt"></i></span>
                                                  <select id="biaya_admin" name="biaya_admin" class="form-control fw-bold" required>
                                                      <option value="">--- Pilih Biaya Admin ---</option>
                                                      <option value="0">Rp. 0</option>
                                                      <option value="3000">Rp. 3.000</option>
                                                  </select>
                                              </div>
                                          </div>

                                          <!-- Pembayaran Melalui -->
                                          <div class="col-md-6">
                                              <label class="form-label fw-bold fs-6">Pembayaran Melalui: </label>
                                              <div class="input-group">
                                                  <span class="input-group-text bg-primary text-white"><i class="bi bi-person-check-fill"></i></span>
                                                  <input type="text" class="form-control" name="nama_sales" value="" placeholder="Masukkan pembayaran melalui..." required>
                                              </div>
                                          </div>

                                          <!-- Keterangan -->
                                          <div class="col-md-6">
                                              <label for="keterangan" class="form-label fw-bold fs-6">Keterangan: </label>
                                              <div class="input-group">
                                                  <span class="input-group-text bg-primary text-white"><i class="bi bi-chat-text-fill"></i></span>
                                                  <input type="text" class="form-control fw-bold" name="keterangan" id="keterangan" placeholder="Masukkan keterangan...">
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
              </div>
          </div>
          <!-- / Content -->