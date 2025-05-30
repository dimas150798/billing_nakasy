<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <!-- Logo Sidebar -->
                <div class="app-brand demo">
                    <a href="<?= base_url('admin/C_Dashboard_Admin') ?>" class="app-brand-link d-flex align-items-center">
                        <img
                            src="<?= base_url('assets/img/Icon_Nakasy.png') ?>"
                            alt="Logo Nakasy"
                            class="img-fluid logo-sidebar">
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
                    </a>
                </div>


                <div class="menu-divider mt-0"></div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    <li class="menu-item">
                        <a
                            href="<?php echo base_url('admin/C_Dashboard_Admin') ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-smile"></i>
                            <div class="text-truncate" data-i18n="Email">Dashboards</div>
                        </a>
                    </li>

                    <!-- Components -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Pelanggan</span></li>

                    <!-- Pelanggan -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div class="text-truncate fs-6" data-i18n="Layouts">Pelanggan</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?php echo base_url('admin/Data_Pelanggan/C_Data_Pelanggan') ?>" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-id-card"></i>
                                    <div class="text-truncate" data-i18n="Without menu">Data Pelanggan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo base_url('admin/Pelanggan_Terminated/C_Pelanggan_Terminated') ?>" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-user-x"></i>
                                    <div class="text-truncate" data-i18n="Without navbar">Pelanggan Terminasi</div>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- Pembayaran -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-credit-card"></i>
                            <div class="text-truncate fs-6" data-i18n="Layouts">Pembayaran</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?php echo base_url('admin/Sudah_Lunas/C_Sudah_Lunas') ?>" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-check-circle"></i>
                                    <div class="text-truncate" data-i18n="Without menu">Sudah Lunas</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo base_url('admin/Belum_Lunas/C_Belum_Lunas') ?>" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-error-circle"></i>
                                    <div class="text-truncate" data-i18n="Without navbar">Belum Lunas</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Components -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Data Master</span></li>

                    <!-- Paket Internet -->
                    <li class="menu-item">
                        <a href="<?php echo base_url('admin/Paket_Internet/C_Paket_Internet') ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-globe"></i>
                            <div class="text-truncate" data-i18n="Basic">Paket Internet</div>
                        </a>
                    </li>

                    <!-- Data ODP -->
                    <li class="menu-item">
                        <a href="<?php echo base_url('admin/Data_ODP/C_Data_ODP') ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-map"></i>
                            <div class="text-truncate" data-i18n="Basic">Data ODP</div>
                        </a>
                    </li>

                    <!-- Data Sales -->
                    <li class="menu-item">
                        <a href="<?php echo base_url('admin/Data_Sales/C_Data_Sales') ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user-voice"></i>
                            <div class="text-truncate" data-i18n="Basic">Data Sales</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <nav
                    class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base bx bx-menu icon-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

                        <!-- Cluster -->
                        <div class="navbar-nav d-flex d-md-none align-items-center w-100">
                            <div class="nav-item ps-3">
                                <div class="text-truncate fw-bold text-black" data-i18n="Basic"> <?= $this->session->userdata('cluster') ?>
                                </div>
                            </div>
                        </div>
                        <!-- /Cluster -->


                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                            <!-- Place this tag where you want the button to render. -->

                            <!-- Cluster -->
                            <li class="nav-item lh-1 me-4 d-none d-md-flex  ms-md-auto">
                                <a
                                    href="#"
                                    class="d-inline-flex align-items-center"
                                    style="background-color: #000; color: #fff; border-radius: 6px; font-size: 14px; padding: 6px 12px; text-decoration: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="me-1" viewBox="0 0 16 16">
                                        <path d="M8 12.146l-3.717 2.325.711-4.146L2 6.868l4.161-.605L8 2.75l1.839 3.513L14 6.868l-2.994 3.457.711 4.146z" />
                                    </svg>
                                    <?= $this->session->userdata('cluster') ?>

                                </a>
                            </li>
                            <!-- /Cluster -->

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a
                                    class="nav-link dropdown-toggle hide-arrow p-0"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="<?php echo base_url(); ?>assets/img/Icon_User.gif" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="<?php echo base_url(); ?>assets/img/Icon_User.gif" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0"> <?= $this->session->userdata('username_email') ?></h6>
                                                    <small class="text-body-secondary"><?= $this->session->userdata('role') ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url('C_FormLogin/logout') ?>">
                                            <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>