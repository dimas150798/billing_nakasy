<!doctype html>

<html
    lang="en"
    class="layout-wide customizer-hide"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Billing Nakasy</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/Icon_Nakasy.png') ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="<?php echo base_url(); ?>assets/vendor/js/helpers.js"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo base_url(); ?>assets/js/config.js"></script>

    <!-- SweetAlert -->
    <link href="<?php echo base_url(); ?>vendor/SweetAlert2/sweetalert2.min.css" rel="stylesheet" />

</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="d-flex justify-content-center align-items-center flex-column text-center my-3">
                            <a href="#" class="app-brand-link gap-2">
                                <img
                                    src="<?= base_url('assets/img/Icon_Nakasy.png') ?>"
                                    alt="Logo Nakasy"
                                    class="img-fluid logo-img">
                            </a>
                        </div>

                        <div class="mb-2">
                            <?php if ($this->session->flashdata('login_error')): ?>
                                <div id="loginAlert" class="alert alert-danger text-center">
                                    <?php echo $this->session->flashdata('login_error'); ?>
                                </div>
                            <?php endif; ?>
                        </div>


                        <?php if ($this->session->flashdata('mikrotik_error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error:</strong> <?= $this->session->flashdata('mikrotik_error'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>


                        <form id="form_login" class="user" method="POST" action="<?php echo base_url('C_FormLogin'); ?>">
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" id="inputEmail" name="email_login" type="email" placeholder="Masukkan email..." />
                                <?php echo form_error('email_login', '<div class="text-small text-danger"></div>') ?>
                            </div>

                            <div class="mb-6">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" id="inputPassword" name="password_login" type="password" placeholder="Masukkan password..." />
                                <?php echo form_error('password_login', '<div class="text-small text-danger"></div>') ?>
                            </div>

                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>


                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>


    <!-- / Content -->

    <!-- Tambahkan ini di bagian head atau sebelum script JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Core JS -->

    <script src="<?php echo base_url(); ?>assets/vendor/libs/jquery/jquery.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/js/bootstrap.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/js/menu.js"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Data Tables -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/af-2.5.1/r-2.4.0/datatables.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.semanticui.min.css" />

    <!-- Font  -->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- SweetAlert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="<?php echo base_url(); ?>vendor/SweetAlert2/sweetalert2.all.min.js"></script> -->

    <!-- Alert Gagal -->
    <script>
        <?php if ($this->session->flashdata('LoginGagal_icon')) { ?>
            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation: false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            toastMixin.fire({
                title: '<?php echo $this->session->flashdata('LoginGagal_title') ?>',
                icon: '<?php echo $this->session->flashdata('LoginGagal_icon') ?>'
            });

        <?php } ?>
    </script>

    <!-- Login Terlebih Dahulu -->
    <script>
        <?php if ($this->session->flashdata('BelumLogin_icon')) { ?>
            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation: false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            toastMixin.fire({
                title: '<?php echo $this->session->flashdata('BelumLogin_title') ?>',
                icon: '<?php echo $this->session->flashdata('BelumLogin_icon') ?>'
            });

        <?php } ?>
    </script>
</body>

</html>