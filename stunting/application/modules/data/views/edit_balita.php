<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header"><?= $title; ?></h5>
        <div class="card-body">
            <?= form_open_multipart('data/update_balita/' . $balita['id'], 'class="form-horizontal"'); ?>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($balita['nama']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input type="radio" id="jenis_kelamin_l" class="form-check-input" name="jenis_kelamin" value="Laki-laki" <?= ($balita['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?> />
                    <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="jenis_kelamin_p" class="form-check-input" name="jenis_kelamin" value="Perempuan" <?= ($balita['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?> />
                    <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" value="<?= $balita['tanggal_lahir']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_ortu" class="form-label">Nama Orang Tua</label>
                <!-- Pastikan nama orang tua tampil, bukan ID -->
                <input type="text" class="form-control" id="ortu" name="ortu_name" value="<?= htmlspecialchars($balita['nama_ortu']); ?>" required autocomplete="off">
                <input type="hidden" id="id_ortu" name="id_ortu" value="<?= $balita['id_ortu']; ?>"> <!-- ID disimpan secara tersembunyi -->
                <div id="suggestions" style="border: 1px solid #ccc; display: none; position: absolute; z-index: 1000; background-color: white;"></div>
                <div id="ortu-error" style="color: red; display: none;">Orang tua tidak ditemukan!</div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($balita['alamat']); ?>" required>
            </div>

            <div class="modal-footer">
                <a href="<?= base_url('data/balita'); ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<!-- JavaScript yang sama untuk pencarian nama orang tua -->
<script>
    $(document).ready(function() {
        $('#ortu').on('input', function() {
            var query = $(this).val();
            if (query.length > 1) {
                $.ajax({
                    url: '<?= base_url('data/search_orang_tua'); ?>',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#suggestions').html(data);
                        $('#suggestions').show();
                    }
                });
            } else {
                $('#suggestions').hide();
            }
        });

        $(document).on('click', '.suggestion-item', function() {
            $('#ortu').val($(this).text());
            $('#id_ortu').val($(this).data('id')); // Menyimpan ID orang tua
            $('#suggestions').hide();
            $('#ortu-error').hide();
        });

        $(document).click(function(event) {
            if (!$(event.target).closest('#ortu').length) {
                $('#suggestions').hide();
            }
        });

        $('form').on('submit', function(e) {
            if ($('#id_ortu').val() === '') {
                e.preventDefault();
                $('#ortu-error').show();
            }
        });
    });
</script>