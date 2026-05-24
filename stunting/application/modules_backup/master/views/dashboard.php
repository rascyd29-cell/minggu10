<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang <?= $user['name']; ?> 🎉</h5>
                                <p class="mb-4">
                                    Cegah <span class="fw-bold">stunting</span>, ciptakan generasi yang <span class="fw-bold">unggul</span>.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/img/illustrations/ilus_dash.png"
                                    height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/ilus_dash.png"
                                    data-app-light-img="illustrations/ilus_dash.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img
                                            src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/img/icons/unicons/ortu.png"
                                            alt="chart success"
                                            class="rounded" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Orang Tua</span>
                                <h3 class="card-title mb-2"><?= $jumlah_orang_tua; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img
                                            src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/img/icons/unicons/balita.png"
                                            alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Balita</span>
                                <h3 class="card-title text-nowrap mb-1"><?= $jumlah_balita; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-4 order-2">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Riwayat Sensor</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <?php foreach ($data2_ as $u) : ?>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/img/icons/unicons/sensor.png" alt="User" class="rounded" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Update</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">

                                            <h6 class="mb-0"><?= $u->time ?></h6>

                                        </div>

                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- / Content -->