<!doctype html>
<html lang="en" class="layout-wide customizer-hide">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Billing Nakasy</title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/Icon_Nakasy.png') ?>" type="image/x-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert -->
    <link href="<?= base_url('vendor/SweetAlert2/sweetalert2.min.css') ?>" rel="stylesheet" />
</head>

<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center font-[Inter]">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        <div class="flex flex-col items-center">
            <img src="<?= base_url('assets/img/Icon_Nakasy.png') ?>" alt="Logo Nakasy" class="w-20 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Login ke Billing Nakasy</h2>
        </div>

        <?php if ($this->session->flashdata('login_error')): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mt-4 text-center">
                <?= $this->session->flashdata('login_error'); ?>
            </div>
        <?php endif; ?>

        <form class="mt-6 space-y-4" method="POST" action="<?= base_url('C_FormLogin'); ?>">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email_login" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan email...">
                <?= form_error('email_login', '<p class="text-sm text-red-600">', '</p>') ?>
            </div>

            <!-- Input Password dengan tombol tampilkan password -->
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password_login" id="password"
                    class="mt-1 block w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Masukkan password...">

                <!-- Eye icon -->
                <button type="button" onclick="togglePassword()" class="absolute top-9 right-3 text-gray-500 hover:text-gray-700">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>

                <?= form_error('password_login', '<p class="text-sm text-red-600">', '</p>') ?>
            </div>



            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">Login</button>
            </div>
        </form>
    </div>

    <!-- SweetAlert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7
                    a10.056 10.056 0 012.923-4.397M15 12a3 3 0 01-6 0M3 3l18 18" />`;
            } else {
                passwordInput.type = "password";
                eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                    -1.274 4.057-5.065 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>



    </script>
    <script>
        <?php if ($this->session->flashdata('LoginGagal_icon')): ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: '<?= $this->session->flashdata('LoginGagal_icon') ?>',
                title: '<?= $this->session->flashdata('LoginGagal_title') ?>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('BelumLogin_icon')): ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: '<?= $this->session->flashdata('BelumLogin_icon') ?>',
                title: '<?= $this->session->flashdata('BelumLogin_title') ?>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>
    </script>
</body>

</html>