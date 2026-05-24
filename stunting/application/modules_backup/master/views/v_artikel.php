<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="demo-inline-spacing">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                <span class="tf-icons bx bx-body"></span>&nbsp; Tambah Artikel
                            </button>
                        </div>

                        <!-- Kolom Pencarian di sebelah kanan -->
                        <div class="input-group" style="max-width: 300px; margin-bottom: 20px;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari data..." onkeyup="searchData()">
                            <button class="btn btn-outline-secondary" type="button" onclick="searchData()">
                                <span class="tf-icons bx bx-search"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table id="mydata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sampul</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="show_data"></tbody>
                </table>
            </div>
        </div>
        <!--/ Hoverable Table rows -->
    </div>
    <!-- / Content -->

    <!-- Add Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addartikelForm">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" id="judul" name="judul" class="form-control" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="isi" class="form-label">Kegiatan</label>
                                <textarea id="isi" name="isi" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" id="gambar" name="gambar" class="form-control" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editArtikelForm">
                        <input type="hidden" id="edit_id" name="edit_id" />
                        <div class="row mb-3">
                            <div class="col">
                                <label for="edit_judul" class="form-label">Judul</label>
                                <input type="text" id="edit_judul" name="edit_judul" class="form-control" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="edit_isi" class="form-label">Kegiatan</label>
                                <textarea id="edit_isi" name="edit_isi" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="edit_gambar" class="form-label">Gambar</label>
                                <input type="file" id="edit_gambar" name="edit_gambar" class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus artikel ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/vendor/js/menu.js"></script>

<script>
    // Fungsi untuk menampilkan data artikel
    function tampil_data_artikel() {
        $.ajax({
            url: '<?= base_url('master/data_artikel') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var html = '';
                var no = 1;
                $.each(data, function(key, item) {
                    html += '<tr>';
                    html += '<td>' + no++ + '</td>';
                    html += '<td><img src="<?= base_url('assets/uploads/') ?>' + item.gambar + '" width="100"></td>';
                    html += '<td>' + item.judul + '</td>';
                    html += '<td>' + item.isi.substring(0, 100) + '...</td>';
                    html += '<td><button class="btn btn-warning btn-sm edit" data-id="' + item.id + '">Edit</button> ' +
                        '<button class="btn btn-danger btn-sm delete" data-id="' + item.id + '">Hapus</button></td>';
                    html += '</tr>';
                });
                $('#show_data').html(html);
            }
        });
    }

    // Fungsi untuk pencarian
    function searchData() {
        var query = $('#searchInput').val();
        $.ajax({
            url: '<?= base_url('master/search2') ?>',
            type: 'GET',
            data: {
                query: query
            },
            success: function(data) {
                $('#show_data').html(data);
            }
        });
    }

    // Menampilkan data artikel saat halaman dimuat
    $(document).ready(function() {
        tampil_data_artikel();

        // Menambahkan artikel
        $('#addartikelForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('master/simpan_artikel') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#basicModal').modal('hide');
                        $('#addartikelForm')[0].reset();
                        tampil_data_artikel(); // Segarkan data artikel
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan artikel.');
                }
            });
        });

        // Mengedit artikel
        $('#show_data').on('click', '.edit', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '<?= base_url('master/get_artikel') ?>',
                type: 'GET',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_judul').val(data.judul);
                    $('#edit_isi').val(data.isi);
                    $('#editModal').modal('show');
                },
                error: function() {
                    alert('Gagal mendapatkan data artikel.');
                }
            });
        });

        // Memperbarui artikel
        $('#editArtikelForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('master/update_artikel') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editModal').modal('hide');
                        tampil_data_artikel(); // Segarkan data artikel setelah edit
                    } else {
                        alert('Gagal memperbarui artikel.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui artikel.');
                }
            });
        });

        // Konfirmasi hapus
        let deleteId;
        $('#show_data').on('click', '.delete', function() {
            deleteId = $(this).data('id');
            $('#confirmDeleteModal').modal('show');
        });

        $('#confirmDelete').click(function() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('master/hapus_artikel') ?>',
                data: {
                    id: deleteId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        tampil_data_artikel(); // Segarkan data artikel
                        $('#confirmDeleteModal').modal('hide'); // Sembunyikan modal konfirmasi
                    } else {
                        alert('Gagal menghapus artikel.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus artikel.');
                }
            });
        });
    });
</script>