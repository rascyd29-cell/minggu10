<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-header"><?= $title; ?></h5>
                </div>
                <div class="card-body">
                    <?php foreach ($data2 as $d) { ?>
                        <?= form_open_multipart('admin/edit', 'role="form" class="form-horizontal"'); ?>
                        <?= form_hidden('id', $d->id); ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" value="<?= $d->name ?>" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" value="<?= $d->email ?>" class="form-control" name="email" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Gambar Profil</label>
                                <div class="mb-2">
                                    <img src="<?= base_url('assets/img/profile/') . $d->image; ?>" class="img-fluid" alt="User Image">
                                </div>
                            </div>
                            <div class=" col-md-6">
                                <label class="form-label">Ubah Gambar</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                    <label class="custom-file-label" for="image">Pilih file</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role_id" required>
                                    <option value="2" <?= $d->role_id == 2 ? 'selected' : ''; ?>>Orang Tua</option>
                                    <option value="3" <?= $d->role_id == 3 ? 'selected' : ''; ?>>Pengelola</option>
                                    <option value="1" <?= $d->role_id == 1 ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status User</label>
                                <select class="form-select" id="is_active" name="is_active" required>
                                    <option value="0" <?= $d->is_active == 0 ? 'selected' : ''; ?>>Tidak Aktif</option>
                                    <option value="1" <?= $d->is_active == 1 ? 'selected' : ''; ?>>Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dibuat Pada</label>
                            <p class="form-control-plaintext"><?= date('d F Y', $d->date_created); ?></p>
                        </div>

                        <div class="text-center">
                            <?= anchor('admin/buatakun', '<button type="button" class="btn btn-secondary">Kembali</button>'); ?>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    <?php } ?>
                    <?= form_close(); // Menutup form 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>