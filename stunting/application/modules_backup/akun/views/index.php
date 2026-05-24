<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold py-3 mb-4"><?= $title; ?></h3>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h3 class="card-header">Detail Akun</h3>
                    <?= $this->session->flashdata('message'); ?>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img
                                src="<?= base_url('assets/img/profile/') . $user['image']; ?>"
                                alt="user-avatar"
                                class="d-block rounded"
                                height="180"
                                width="180"
                                id="uploadedAvatar" />
                            <div>
                                <h3><strong><?= $user['name']; ?></strong></h3>
                                <p class="card-text"><small class="text-muted">Tanggal Buat Akun : <?= date('d F Y', $user['date_created']); ?></small></p>
                                <?= form_open_multipart('akun'); ?>
                                <div class="col-sm-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                    </div>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>

                    <hr class="my-0" />
                    <div class="card-body">
                        <?= form_open('akun'); ?>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input class="form-control" type="text" id="name" name="name" value="<?= $user['name']; ?>" autofocus />
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email" value="<?= $user['email']; ?>" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="current_password" class="form-label">Password Saat ini</label>
                                <input class="form-control" type="password" id="current_password" name="current_password" />
                                <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="new_password1" class="form-label">Password Baru</label>
                                <input class="form-control" type="password" id="new_password1" name="new_password1" />
                                <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="new_password2" class="form-label">Ulangi Password Baru</label>
                                <input class="form-control" type="password" id="new_password2" name="new_password2" />
                                <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                            <button type="reset" class="btn btn-outline-secondary">Batalkan</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>