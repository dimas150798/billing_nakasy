<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">

            <!-- Card Item -->
            <?php
            $cards = [
                ['icon' => 'bi-person-fill-add', 'label' => 'Pelanggan Baru', 'value' => $Pelanggan_Baru],
                ['icon' => 'bi-person-circle', 'label' => 'Total Pelanggan', 'value' => $Total_Pelanggan],
                ['icon' => 'bi-patch-check', 'label' => 'Pelanggan Lunas', 'value' => 0],
                ['icon' => 'bi-patch-exclamation', 'label' => 'Pelanggan Belum Lunas', 'value' => 0]
            ];

            foreach ($cards as $card): ?>
                <div class="col-sm-6 col-xl-3">
                    <div class="card shadow-sm border-0 h-100 card-hover">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="icon-box bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi <?= $card['icon'] ?> fs-4 text-primary"></i>
                            </div>
                            <div class="text-start">
                                <small class="text-muted"><?= $card['label'] ?></small>
                                <h4 class="mb-0 mt-1 fw-semibold"><?= $card['value'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- / Content -->
</div>