<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php
$idmakan_pagi = $subMenu[0]->idData_makanan;
$idmakan_siang = $subMenu[4]->idData_makanan;
$idmakan_malam = $subMenu[8]->idData_makanan;
$idmakan_selinganPG = $selingan[0]->idData_makanan;
$idmakan_selinganSR = $selingan[1]->idData_makanan;
?>

<form action="<?php echo site_url('master/update/' . $idmakan_pagi . '/' . $idmakan_siang . '/' . $idmakan_malam . '/' . $idmakan_selinganPG . '/' . $idmakan_selinganSR); ?>" method="POST">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="container mt-3 mb-3">
        <!-- Form input pagi -->
        <div class="card mt-1 mb-5 shadow" id="cardTemplate">
            <div class="card-body">
                <div class="form-group form-template">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold">Menu Makanan</h4>
                    </div>
                    <div class="form-group form-template">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">#Form Edit Menu Pagi</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="paket" class="form-label">Paket</label>
                                    <select class="form-control" name="paket">
                                        <option value="<?php echo $subMenu[0]->paket; ?>"><?php echo $subMenu[0]->paket; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="waktu_makan" class="form-label">Waktu Makan</label>
                                    <input type="text" class="form-control" value="<?php echo $subMenu[0]->waktu_makan; ?>" disabled>
                                    <input type="hidden" name="waktumakan_pagi" value="<?php echo $subMenu[0]->waktu_makan; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="menu" class="form-label">Menu</label>
                                    <input type="text" class="form-control" name="menu_pagi" value="<?php echo $subMenu[0]->menu; ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Makanan Pokok -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <label for="nama_makanan" class="form-label">Nama</label>
                                            <input type="text" class="form-control me-3" name="mp_pagi" value="<?php echo $subMenu[0]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[0]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" value="makananpokok" name="j_mp">
                                        </div>
                                        <div class="me-2">
                                            <label for="protein" class="form-label">Protein</label>
                                            <input type="text" class="form-control me-3" name="proteinmp_pagi" value="<?php echo $subMenu[0]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Karbohidrat</label>
                                            <input type="text" class="form-control" name="karbomp_pagi" value="<?php echo $subMenu[0]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Lemak</label>
                                            <input type="text" class="form-control" name="lemakmp_pagi" value="<?php echo $subMenu[0]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <label for="karbo" class="form-label">Energi</label>
                                            <input type="text" class="form-control" name="energimp_pagi" value="<?php echo $subMenu[0]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Lauk -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="lauk_pagi" value="<?php echo $subMenu[1]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[1]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" value="<?php echo $subMenu[1]->jenis_makanan; ?>" name="j_lauk">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinlauk_pagi" value="<?php echo $subMenu[1]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbolauk_pagi" value="<?php echo $subMenu[1]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaklauk_pagi" value="<?php echo $subMenu[1]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energilauk_pagi" value="<?php echo $subMenu[1]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Sayur -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="syr_pagi" value="<?php echo $subMenu[2]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[2]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" value="<?php echo $subMenu[2]->jenis_makanan; ?>" name="j_sayur">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinsyr_pagi" value="<?php echo $subMenu[2]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbosyr_pagi" value="<?php echo $subMenu[2]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaksyr_pagi" value="<?php echo $subMenu[2]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energisyr_pagi" value="<?php echo $subMenu[2]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Buah -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="buah_pagi" value="<?php echo $subMenu[3]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[3]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="j_buah" value="<?php echo $subMenu[3]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinbuah_pagi" value="<?php echo $subMenu[3]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbobuah_pagi" value="<?php echo $subMenu[3]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemakbuah_pagi" value="<?php echo $subMenu[3]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energibuah_pagi" value="<?php echo $subMenu[3]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form input siang -->
            <div class="card mt-1 mb-5 shadow" id="cardTemplate">
                <div class="card-body">
                    <div class="form-group form-template">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">#Form Edit Menu Siang</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="waktu_makan" class="form-label">Waktu Makan</label>
                                    <input type="text" class="form-control" value="<?php echo $subMenu[4]->waktu_makan; ?>" disabled>
                                    <input type="hidden" name="waktumakan_siang" value="<?php echo $subMenu[4]->waktu_makan; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="menu" class="form-label">Menu</label>
                                    <input type="text" class="form-control" name="menu_siang" value="<?php echo $subMenu[4]->menu; ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Makanan Pokok -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <label for="nama_makanan" class="form-label">Nama Makanan</label>
                                            <input type="text" class="form-control me-3" name="mp_siang" value="<?php echo $subMenu[4]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[4]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="jmp_siang" value="<?php echo $subMenu[4]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="protein" class="form-label">Protein</label>
                                            <input type="text" class="form-control me-3" name="proteinmp_siang" value="<?php echo $subMenu[4]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Karbohidrat</label>
                                            <input type="text" class="form-control" name="karbomp_siang" value="<?php echo $subMenu[4]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Lemak</label>
                                            <input type="text" class="form-control" name="lemakmp_siang" value="<?php echo $subMenu[4]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <label for="energi" class="form-label">Energi</label>
                                            <input type="text" class="form-control" name="energimp_siang" value="<?php echo $subMenu[4]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Lauk -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="lauk_siang" value="<?php echo $subMenu[5]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[5]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="jlauk_siang" value="<?php echo $subMenu[5]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinlauk_siang" value="<?php echo $subMenu[5]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbolauk_siang" value="<?php echo $subMenu[5]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaklauk_siang" value="<?php echo $subMenu[5]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energilauk_siang" value="<?php echo $subMenu[5]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Sayur -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="syr_siang" value="<?php echo $subMenu[6]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[6]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="jsyr_siang" value="<?php echo $subMenu[6]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinsyr_siang" value="<?php echo $subMenu[6]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbosyr_siang" value="<?php echo $subMenu[6]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaksyr_siang" value="<?php echo $subMenu[6]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energisyr_siang" value="<?php echo $subMenu[6]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Buah -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="buah_siang" value="<?php echo $subMenu[7]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[7]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="j_buah" value="<?php echo $subMenu[7]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinbuah_siang" value="<?php echo $subMenu[7]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbobuah_siang" value="<?php echo $subMenu[7]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemakbuah_siang" value="<?php echo $subMenu[7]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energibuah_siang" value="<?php echo $subMenu[7]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form input malam -->
            <div class="card mt-1 mb-5 shadow" id="cardTemplate">
                <div class="card-body">
                    <div class="form-group form-template">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">#Form Edit Menu Malam</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="waktu_makan" class="form-label">Waktu Makan</label>
                                    <input type="text" class="form-control" value="<?php echo $subMenu[8]->waktu_makan; ?>" disabled>
                                    <input type="hidden" name="waktumakan_malam" value="<?php echo $subMenu[8]->waktu_makan; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="menu" class="form-label">Menu</label>
                                    <input type="text" class="form-control" name="menu_malam" value="<?php echo $subMenu[8]->menu; ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Makanan Pokok -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <label for="nama_makanan" class="form-label">Nama Makanan</label>
                                            <input type="text" class="form-control me-3" name="mp_malam" value="<?php echo $subMenu[8]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[8]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="jmp_malam" value="<?php echo $subMenu[8]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="protein" class="form-label">Protein</label>
                                            <input type="text" class="form-control me-3" name="proteinmp_malam" value="<?php echo $subMenu[8]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Karbohidrat</label>
                                            <input type="text" class="form-control" name="karbomp_malam" value="<?php echo $subMenu[8]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Lemak</label>
                                            <input type="text" class="form-control" name="lemakmp_malam" value="<?php echo $subMenu[8]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <label for="energi" class="form-label">Energi</label>
                                            <input type="text" class="form-control" name="energimp_malam" value="<?php echo $subMenu[8]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Lauk -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="lauk_malam" value="<?php echo $subMenu[9]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[9]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="jlauk_malam" value="<?php echo $subMenu[9]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinlauk_malam" value="<?php echo $subMenu[9]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbolauk_malam" value="<?php echo $subMenu[9]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaklauk_malam" value="<?php echo $subMenu[9]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energilauk_malam" value="<?php echo $subMenu[9]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Sayur -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="syr_malam" value="<?php echo $subMenu[10]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[10]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="jsyr_malam" value="<?php echo $subMenu[10]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinsyr_malam" value="<?php echo $subMenu[10]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbosyr_malam" value="<?php echo $subMenu[10]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaksyr_malam" value="<?php echo $subMenu[10]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energisyr_malam" value="<?php echo $subMenu[10]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Buah -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="buah_malam" value="<?php echo $subMenu[11]->nama_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="<?php echo $subMenu[11]->jenis_makanan; ?>" disabled>
                                            <input type="hidden" name="j_buah" value="<?php echo $subMenu[11]->jenis_makanan; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinbuah_malam" value="<?php echo $subMenu[11]->protein; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbobuah_malam" value="<?php echo $subMenu[11]->karbohidrat; ?>">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemakbuah_malam" value="<?php echo $subMenu[11]->lemak; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energibuah_malam" value="<?php echo $subMenu[11]->energi; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php foreach ($selingan as $item): ?>
                <?php if ($item->waktu_makan == 'selingan pagi'): ?>
                    <!-- Form input selingan pagi -->
                    <div class="card mt-1 mb-5 shadow" id="cardTemplate">
                        <div class="card-body">
                            <div class="form-group form-template ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold">#Form Edit Selingan Pagi</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="waktu_makan" class="form-label">Waktu Selingan</label>
                                            <input type="text" class="form-control" value="selingan pagi" disabled>
                                            <input type="hidden" name="waktumakan_SPagi" value="selingan pagi">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="nama_makanan" class="form-label">Menu</label>
                                            <input type="text" class="form-control" name="menuselingan_pagi" value="<?php echo $item->menu; ?>">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-around">
                                                <div class="me-2">
                                                    <label for="protein" class="form-label">Protein</label>
                                                    <input type="text" class="form-control me-3" name="proteinselingan_pagi" value="<?php echo $item->protein; ?>">
                                                </div>
                                                <div class="me-2">
                                                    <label for="karbo" class="form-label">Karbohidrat</label>
                                                    <input type="text" class="form-control" name="karboselingan_pagi" value="<?php echo $item->karbohidrat; ?>">
                                                </div>
                                                <div class="me-2">
                                                    <label for="karbo" class="form-label">Lemak</label>
                                                    <input type="text" class="form-control" name="lemakselingan_pagi" value="<?php echo $item->lemak; ?>">
                                                </div>
                                                <div class="">
                                                    <label for="energi" class="form-label">Energi</label>
                                                    <input type="text" class="form-control" name="energiselingan_pagi" value="<?php echo $item->energi; ?>">
                                                </div>
                                                <div class="">
                                                    <input type="hidden" name="iddatamakanan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($item->waktu_makan == 'selingan sore'): ?>
                    <!-- Form input selingan sore -->
                    <div class="card mt-1 mb-5 shadow" id="cardTemplate">
                        <div class="card-body">
                            <div class="form-group form-template ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold">#Form Edit Selingan Sore</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="waktu_makan" class="form-label">Waktu Sore</label>
                                            <input type="text" class="form-control" value="selingan sore" disabled>
                                            <input type="hidden" name="waktumkn_Ssore" value="selingan sore">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="nama_makanan" class="form-label">Menu</label>
                                            <input type="text" class="form-control" name="menuselingan_sore" value="<?php echo $item->menu; ?>">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-around">
                                                <div class="me-2">
                                                    <label for="protein" class="form-label">Protein</label>
                                                    <input type="text" class="form-control me-3" name="proteinselingan_sore" value="<?php echo $item->protein; ?>">
                                                </div>
                                                <div class="me-2">
                                                    <label for="karbo" class="form-label">Karbohidrat</label>
                                                    <input type="text" class="form-control" name="karboselingan_sore" value="<?php echo $item->karbohidrat; ?>">
                                                </div>
                                                <div class="me-2">
                                                    <label for="karbo" class="form-label">Lemak</label>
                                                    <input type="text" class="form-control" name="lemakselingan_sore" value="<?php echo $item->lemak; ?>">
                                                </div>
                                                <div class="">
                                                    <label for="energi" class="form-label">Energi</label>
                                                    <input type="text" class="form-control" name="energiselingan_sore" value="<?php echo $item->energi; ?>">
                                                </div>
                                                <div class="">
                                                    <input type="hidden" name="iddatamakanan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <!-- Tombol untuk menyalin form -->
            <div class="container d-flex gap-2 mt-3 mx-4">
                <button type="submit" class="btn btn-success" id="submitButton" style="background-color: green">Simpan</button>
            </div>

        </div>
</form>