<form action="<?php echo site_url('master/store'); ?>" method="post">
    <div class="container mt-3 mb-3">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <div class="card mt-1 mb-5 shadow" id="cardTemplate">
            <div class="card-body">
                <div class="form-group form-template">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold">Menu Makanan</h4>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold">#Form Input Menu Pagi</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="paket" class="form-label">Paket</label>
                                <input type="text" class="form-control" name="paket" placeholder="Paket ....">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="waktu_makan" class="form-label">Waktu Makan</label>
                                <input type="text" class="form-control" value="makan pagi" disabled>
                                <input type="hidden" name="waktumakan_pagi" value="makan pagi">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="menu" class="form-label">Menu</label>
                                <input type="text" class="form-control" name="menu_pagi">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- makanan pokok -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-around">
                                    <div class="me-2">
                                        <label for="nama_makanan" class="form-label">Nama</label>
                                        <input type="text" class="form-control me-3" name="mp_pagi">
                                    </div>
                                    <div class="me-2">
                                        <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                                        <input type="text" class="form-control me-3" value="makananpokok" disabled>
                                        <input type="hidden" value="makananpokok" name="j_mp">
                                    </div>
                                    <div class="me-2">
                                        <label for="protein" class="form-label">Protein</label>
                                        <input type="text" class="form-control me-3" name="proteinmp_pagi">
                                    </div>
                                    <div class="me-2">
                                        <label for="karbo" class="form-label">Karbohidrat</label>
                                        <input type="text" class="form-control" name="karbomp_pagi">
                                    </div>
                                    <div class="me-2">
                                        <label for="karbo" class="form-label">lemak</label>
                                        <input type="text" class="form-control" name="lemakmp_pagi">
                                    </div>
                                    <div class="">
                                        <label for="karbo" class="form-label">energi</label>
                                        <input type="text" class="form-control" name="energimp_pagi">
                                    </div>
                                </div>
                            </div>
                            <!-- lauk -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-around">
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="lauk_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" value="lauk" disabled>
                                        <input type="hidden" value="lauk" name="j_lauk">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="proteinlauk_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="karbolauk_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="lemaklauk_pagi">
                                    </div>
                                    <div class="">
                                        <input type="text" class="form-control" name="energilauk_pagi">
                                    </div>
                                </div>
                            </div>
                            <!-- sayur -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-around">
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="syr_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" value="sayur" disabled>
                                        <input type="hidden" value="sayur" name="j_sayur">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="proteinsyr_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="karbosyr_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="lemaksyr_pagi">
                                    </div>
                                    <div class="">
                                        <input type="text" class="form-control" name="energisyr_pagi">
                                    </div>
                                </div>
                            </div>
                            <!-- buah -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-around">
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="buah_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" value="buah" disabled>
                                        <input type="hidden" name="j_buah" value="buah">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="proteinbuah_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="karbobuah_pagi">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="lemakbuah_pagi">
                                    </div>
                                    <div class="">
                                        <input type="text" class="form-control" name="energibuah_pagi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- form input siang -->
            <div class="card mt-1 mb-5 shadow" id="cardTemplate">
                <div class="card-body">
                    <div class="form-group form-template">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">#Form Input Menu Siang</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="waktu_makan" class="form-label">Waktu Makan</label>
                                    <input type="text" class="form-control" value="makan siang" disabled>
                                    <input type="hidden" name="waktumakan_siang" value="makan siang">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="menu" class="form-label">Menu</label>
                                    <input type="text" class="form-control" name="menu_siang">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- makanan pokok -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <label for="nama_makanan" class="form-label">Nama makanan</label>
                                            <input type="text" class="form-control me-3" name="mp_siang">
                                        </div>
                                        <div class="me-2">
                                            <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                                            <input type="text" class="form-control me-3" value="makananpokok" disabled>
                                            <input type="hidden" name="jmp_siang" value="makananpokok">
                                        </div>
                                        <div class="me-2">
                                            <label for="protein" class="form-label">Protein</label>
                                            <input type="text" class="form-control me-3" name="proteinmp_siang">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Karbohidrat</label>
                                            <input type="text" class="form-control" name="karbomp_siang">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">lemak</label>
                                            <input type="text" class="form-control" name="lemakmp_siang">
                                        </div>
                                        <div class="">
                                            <label for="karbo" class="form-label">energi</label>
                                            <input type="text" class="form-control" name="energimp_siang">
                                        </div>
                                    </div>
                                </div>
                                <!-- lauk -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="lauk_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="lauk" disabled>
                                            <input type="hidden" name="jlauk_siang" value="lauk">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinlauk_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbolauk_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaklauk_siang">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energilauk_siang">
                                        </div>
                                    </div>
                                </div>
                                <!-- sayur -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="syr_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="sayur" disabled>
                                            <input type="hidden" name="jsyr_siang" value="sayur">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinsyr_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbosyr_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaksyr_siang">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energisyr_siang">
                                        </div>
                                    </div>
                                </div>

                                <!-- buah -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="buah_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="buah" disabled>
                                            <input type="hidden" name="j_buah" value="buah">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinbuah_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbobuah_siang">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemakbuah_siang">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energibuah_siang">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- form input malam -->
            <div class="card mt-1 mb-5 shadow" id="cardTemplate">
                <div class="card-body">
                    <div class="form-group form-template">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">#Form Input Menu Malam</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="waktu_makan" class="form-label">Waktu Makan</label>
                                    <input type="text" class="form-control" value="makan malam" disabled>
                                    <input type="hidden" name="waktumakan_malam" value="makan malam">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="menu" class="form-label">Menu</label>
                                    <input type="text" class="form-control" name="menu_malam">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- makanan pokok -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <label for="nama_makanan" class="form-label">Nama makanan</label>
                                            <input type="text" class="form-control me-3" name="mp_malam">
                                        </div>
                                        <div class="me-2">
                                            <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                                            <input type="text" class="form-control me-3" value="makananpokok" disabled>
                                            <input type="hidden" value="makananpokok" name="jmp_malam">
                                        </div>
                                        <div class="me-2">
                                            <label for="protein" class="form-label">Protein</label>
                                            <input type="text" class="form-control me-3" name="proteinmp_malam">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">Karbohidrat</label>
                                            <input type="text" class="form-control" name="karbomp_malam">
                                        </div>
                                        <div class="me-2">
                                            <label for="karbo" class="form-label">lemak</label>
                                            <input type="text" class="form-control" name="lemakmp_malam">
                                        </div>
                                        <div class="">
                                            <label for="karbo" class="form-label">energi</label>
                                            <input type="text" class="form-control" name="energimp_malam">
                                        </div>
                                    </div>
                                </div>
                                <!-- lauk -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="lauk_malam">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="lauk" disabled>
                                            <input type="hidden" name="jlauk_malam" value="lauk">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinlauk_malam">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbolauk_malam">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaklauk_malam">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energilauk_malam">
                                        </div>
                                    </div>
                                </div>
                                <!-- sayur -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-around">
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="syr_malam">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" value="sayur" disabled>
                                            <input type="hidden" value="sayur" name="jsyr_malam">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control me-3" name="proteinsyr_malam">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="karbosyr_malam">
                                        </div>
                                        <div class="me-2">
                                            <input type="text" class="form-control" name="lemaksyr_malam">
                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="energisyr_malam">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- buah -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-around">
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="buah_malam">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" value="buah" disabled>
                                        <input type="hidden" value="buah" name="j_buah">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control me-3" name="proteinbuah_malam">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="karbobuah_malam">
                                    </div>
                                    <div class="me-2">
                                        <input type="text" class="form-control" name="lemakbuah_malam">
                                    </div>
                                    <div class="">
                                        <input type="text" class="form-control" name="energibuah_malam">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- form input selingan pagi -->
        <div class="card mt-1 mb-5 shadow" id="cardTemplate">
            <div class="card-body">
                <div class="form-group form-template">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold">#Form Input Selingan Pagi</h5>
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
                                <label for="menu" class="form-label">Menu</label>
                                <input type="text" class="form-control" name="menuselingan_pagi">
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
                                        <input type="text" class="form-control me-3" name="proteinselingan_pagi">
                                    </div>
                                    <div class="me-2">
                                        <label for="karbo" class="form-label">Karbohidrat</label>
                                        <input type="text" class="form-control" name="karboselingan_pagi">
                                    </div>
                                    <div class="me-2">
                                        <label for="karbo" class="form-label">lemak</label>
                                        <input type="text" class="form-control" name="lemakselingan_pagi">
                                    </div>
                                    <div class="">
                                        <label for="karbo" class="form-label">energi</label>
                                        <input type="text" class="form-control" name="energiselingan_pagi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- form input selingan sore -->
        <div class="card mt-1 mb-5 shadow" id="cardTemplate">
            <div class="card-body">
                <div class="form-group form-template">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold">#Form Input Selingan Sore</h5>
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
                                <label for="menu" class="form-label">Menu</label>
                                <input type="text" class="form-control" name="menuselingan_sore">
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
                                        <input type="text" class="form-control me-3" name="proteinselingan_sore">
                                    </div>
                                    <div class="me-2">
                                        <label for="karbo" class="form-label">Karbohidrat</label>
                                        <input type="text" class="form-control" name="karboselingan_sore">
                                    </div>
                                    <div class="me-2">
                                        <label for="karbo" class="form-label">lemak</label>
                                        <input type="text" class="form-control" name="lemakselingan_sore">
                                    </div>
                                    <div class="">
                                        <label for="karbo" class="form-label">energi</label>
                                        <input type="text" class="form-control" name="energiselingan_sore">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tombol untuk menyalin form -->
    <div class="container d-flex gap-2 mt-3 mx-4">
        <!-- <button type="button" class="btn btn-primary" id="copyForm" style="background-color: blue">TambahForm</button> -->
        <button type="submit" class="btn btn-success" id="submitButton" style="background-color: green">Submit</button>
    </div>
    </div>
</form>