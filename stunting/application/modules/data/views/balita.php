<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class="menu-icon tf-icons bx bx-body"></i>&nbsp; Tambah Balita
                    </button>
                </div>
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= $this->session->flashdata('message'); ?>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Orang Tua</th> <!-- Perbarui header ini -->
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="show_data">
                            <?php $no = 1;
                            foreach ($balita as $u): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($u->nama); ?></td>
                                    <td><?= htmlspecialchars($u->jenis_kelamin); ?></td>
                                    <td><?= htmlspecialchars($u->tanggal_lahir); ?></td>
                                    <td><?= htmlspecialchars($u->nama_ortu); ?></td> <!-- Menampilkan nama orang tua -->
                                    <td><?= htmlspecialchars($u->alamat); ?></td>
                                    <td>
                                        <a href="<?= base_url('data/edit_balita/' . $u->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $u->id; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Balita -->
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Balita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?= form_open_multipart('data/add_balita', 'role="form" class="form-horizontal"'); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Balita" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Jenis Kelamin</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="Laki-laki" value="Laki-laki" required>
                                    <label class="form-check-label" for="male">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan" required>
                                    <label class="form-check-label" for="female">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dobBasic" class="form-label">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" required />
                        </div>
                        <div class="mb-3">
                            <label for="ortu" class="form-label">Nama Orang Tua</label>
                            <input type="text" class="form-control" id="ortu" name="ortu_name" placeholder="Ketik Nama Orang Tua" required autocomplete="off">
                            <input type="hidden" id="id_ortu" name="id_ortu" required> <!-- Hidden input untuk ID orang tua -->
                            <div id="suggestions" style="border: 1px solid #ccc; display: none; position: absolute; z-index: 1000; background-color: white;"></div>
                            <div id="ortu-error" style="color: red; display: none;">Orang tua tidak ditemukan!</div> <!-- Pesan kesalahan -->
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Tulis Alamat" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>

<!-- JS for searching and managing data -->
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data tidak dapat dipulihkan setelah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "<?= base_url('data/hapus_balita/'); ?>" + userId;
            }
        });
    }

    $(document).ready(function() {
        $('#ortu').on('input', function() {
            var query = $(this).val();

            if (query.length > 1) {
                $.ajax({
                    url: '<?= base_url('data/search_orang_tua'); ?>', // URL untuk AJAX
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

        // Pilih nama orang tua dari saran
        $(document).on('click', '.suggestion-item', function() {
            $('#ortu').val($(this).text()); // Set input dengan nama yang dipilih
            $('#id_ortu').val($(this).data('id')); // Set hidden input dengan ID orang tua
            $('#suggestions').hide(); // Sembunyikan saran setelah memilih
            $('#ortu-error').hide(); // Sembunyikan pesan kesalahan
        });

        // Menyembunyikan saran saat mengklik di luar
        $(document).click(function(event) {
            if (!$(event.target).closest('#ortu').length) {
                $('#suggestions').hide();
            }
        });

        // Validasi sebelum menyimpan
        $('form').on('submit', function(e) {
            if ($('#id_ortu').val() === '') {
                e.preventDefault(); // Hentikan pengiriman formulir
                $('#ortu-error').show(); // Tampilkan pesan kesalahan
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'csv'
            ]
        });
    });

    $(document).ready(function() {
        // Inisialisasi Select2
        $('#id_ortu').select2({
            placeholder: "Pilih Orang Tua",
            allowClear: true
        });

        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'csv'
            ]
        });
    });
</script>