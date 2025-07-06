<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Navbar -->
        <nav class="navbar navbar-dark bg-dark shadow-sm border-bottom" style="border-color: #0d6efd;">
            <div class="container-fluid d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn p-2 d-lg-none me-2 text-white border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                        <i class="bx bx-menu fs-4"></i>
                    </button>
                    <a class="navbar-brand fw-bold mb-0 me-3" href="#">Panel Billing</a>
                </div>

                <!-- Menu hanya tampil di layar besar -->
                <ul class="nav nav-pills d-none d-lg-flex ms-2">
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_Pelanggan' ? 'active' : '' ?>" href="<?= base_url('admin/Data_Pelanggan/C_Data_Pelanggan') ?>">
                            <i class="bx bx-user me-1"></i> Pelanggan
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_Gangguan_Pelanggan' ? 'active' : '' ?>" href="<?= base_url('admin/OOS_Pelanggan/C_OOS_Pelanggan') ?>">
                            <i class="bx bx-error me-1"></i> OOS
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_Terminasi' ? 'active' : '' ?>" href="<?= base_url('admin/Pelanggan_Terminated/C_Pelanggan_Terminated') ?>">
                            <i class="bx bx-user-x me-1"></i> Terminasi
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_Sudah_Lunas' ? 'active' : '' ?>" href="<?= base_url('admin/Sudah_Lunas/C_Sudah_Lunas') ?>">
                            <i class="bx bx-check-circle me-1"></i> Sudah Lunas
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_Belum_Lunas' ? 'active' : '' ?>" href="<?= base_url('admin/Belum_Lunas/C_Belum_Lunas') ?>">
                            <i class="bx bx-x-circle me-1"></i> Belum Lunas
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_Paket' ? 'active' : '' ?>" href="<?= base_url('admin/Paket_Internet/C_Paket_Internet') ?>">
                            <i class="bx bx-globe me-1"></i> Paket
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_ODP' ? 'active' : '' ?>" href="<?= base_url('admin/Data_ODP/C_Data_ODP') ?>">
                            <i class="bx bx-map me-1"></i> ODP
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-white fw-semibold <?= $this->uri->segment(3) == 'C_Pegawai' ? 'active' : '' ?>" href="<?= base_url('admin/Data_Sales/C_Data_Sales') ?>">
                            <i class="bx bx-id-card me-1"></i> Pegawai
                        </a>
                    </li>
                </ul>

                <!-- User -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= base_url('assets/img/Icon_User.gif') ?>" alt="User" class="rounded-circle" style="width: 40px; height: auto;" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 220px;">
                            <li class="px-3 py-2">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('assets/img/Icon_User.gif') ?>" alt="User" class="rounded-circle me-2" style="width: 40px; height: auto;" />
                                    <div>
                                        <h6 class="mb-0"><?= $this->session->userdata('username_email') ?></h6>
                                        <small class="text-muted"><?= $this->session->userdata('role') ?></small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('C_FormLogin/logout') ?>">
                                    <i class="bx bx-power-off me-2"></i> Log Out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        <!-- Sidebar Offcanvas (Mobile Only) -->
        <div class="offcanvas offcanvas-start offcanvas-modern text-white d-lg-none" tabindex="-1" id="sidebarMenu">
            <div class="offcanvas-header border-bottom border-secondary">
                <h5 class="offcanvas-title fw-bold text-white">Panel Billing</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body p-3">

                <!-- Section: Pelanggan -->
                <div class="section-title">Pelanggan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center text-white fw-medium <?= $this->uri->segment(3) == 'C_Pelanggan' ? 'active' : '' ?>" href="<?= base_url('admin/Data_Pelanggan/C_Data_Pelanggan') ?>">
                            <i class="bx bx-user me-3 fs-5 text-success icon-rounded"></i> Pelanggan Aktif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center text-white fw-medium <?= $this->uri->segment(3) == 'C_Terminasi' ? 'active' : '' ?>" href="<?= base_url('admin/Pelanggan_Terminated/C_Pelanggan_Terminated') ?>">
                            <i class="bx bx-user-x me-3 fs-5 text-danger icon-rounded"></i> Pelanggan Terminasi
                        </a>
                    </li>
                </ul>

                <!-- Section: Pembayaran -->
                <div class="section-title">Pembayaran</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center text-white fw-medium <?= $this->uri->segment(3) == 'C_Sudah_Lunas' ? 'active' : '' ?>" href="<?= base_url('admin/Sudah_Lunas/C_Sudah_Lunas') ?>">
                            <i class="bx bx-check-circle me-3 fs-5 text-primary icon-rounded"></i> Sudah Lunas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center text-white fw-medium <?= $this->uri->segment(3) == 'C_Belum_Lunas' ? 'active' : '' ?>" href="<?= base_url('admin/Belum_Lunas/C_Belum_Lunas') ?>">
                            <i class="bx bx-x-circle me-3 fs-5 text-warning icon-rounded"></i> Belum Lunas
                        </a>
                    </li>
                </ul>

                <!-- Section: Data Master -->
                <div class="section-title">Data Master</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center text-white fw-medium <?= $this->uri->segment(3) == 'C_Paket' ? 'active' : '' ?>" href="<?= base_url('admin/Paket_Internet/C_Paket_Internet') ?>">
                            <i class="bx bx-globe me-3 fs-5 text-info icon-rounded"></i> Paket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center text-white fw-medium <?= $this->uri->segment(3) == 'C_ODP' ? 'active' : '' ?>" href="<?= base_url('admin/Data_ODP/C_Data_ODP') ?>">
                            <i class="bx bx-map me-3 fs-5 text-warning icon-rounded"></i> ODP
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center text-white fw-medium <?= $this->uri->segment(3) == 'C_Pegawai' ? 'active' : '' ?>" href="<?= base_url('admin/Data_Sales/C_Data_Sales') ?>">
                            <i class="bx bx-id-card me-3 fs-5 text-warning icon-rounded"></i> Pegawai
                        </a>
                    </li>
                </ul>

            </div>
        </div>