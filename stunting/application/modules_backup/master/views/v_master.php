<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header"><?= $title; ?></h5>
                    <!-- Account -->
                    <hr class="my-0" />
                    <div class="card-body">
                        <?= form_open_multipart('master') ?>
                        <div class="row">
                            <div class="mb-3 col-md-12" hidden>
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="text" id="email" name="email" value="<?= $user['email']; ?>" readonly />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="desa" class="form-label">Desa</label>
                                <input class="form-control" type="text" id="desa" name="desa" value="<?= $user['desa']; ?>" readonly />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input class="form-control" type="text" id="kecamatan" name="kecamatan" value="<?= $user['kecamatan']; ?>" readonly />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="kabupaten" class="form-label">Kabupaten</label>
                                <input class="form-control" type="text" id="kabupaten" name="kabupaten" value="<?= $user['kabupaten']; ?>" readonly />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input class="form-control" type="text" id="provinsi" name="provinsi" value="<?= $user['provinsi']; ?>" readonly />
                            </div>
                            <hr class="my-0" />
                            <div class="mb-3 col-md-12">
                                <label for="nama_bidan" class="form-label">Nama Nakes</label>
                                <input class="form-control" type="text" id="nama_bidan" name="name" value="<?= $user['name']; ?>" readonly />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" id="editButton" class="btn btn-secondary">Edit</button>
                            <button type="submit" class="btn btn-primary me-2" id="saveButton" style="display: none;">Save changes</button>
                            <button type="button" class="btn btn-outline-secondary" id="cancelButton" style="display: none;">Cancel</button>
                        </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript untuk mengaktifkan edit mode dan menampilkan tombol Save & Cancel
    document.getElementById('editButton').addEventListener('click', function() {
        let inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            if (input.type !== 'hidden') {
                input.removeAttribute('readonly'); // Hapus readonly
            }
        });

        // Tampilkan tombol Save & Cancel, sembunyikan tombol Edit
        document.getElementById('saveButton').style.display = 'inline-block';
        document.getElementById('cancelButton').style.display = 'inline-block';
        document.getElementById('editButton').style.display = 'none';
    });

    // JavaScript untuk tombol Cancel
    document.getElementById('cancelButton').addEventListener('click', function() {
        let inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.setAttribute('readonly', true); // Kembalikan readonly pada semua input
        });

        // Sembunyikan tombol Save & Cancel, tampilkan tombol Edit
        document.getElementById('saveButton').style.display = 'none';
        document.getElementById('cancelButton').style.display = 'none';
        document.getElementById('editButton').style.display = 'inline-block';

        // Arahkan kembali ke halaman master
        window.location.href = '<?= base_url("master"); ?>';
    });
</script>