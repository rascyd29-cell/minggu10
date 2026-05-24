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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#basicModal">
                                    <span class="tf-icons bx bx-body"></span>&nbsp; Tambah Jadwal
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
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Jam</th>
                                <th>Lokasi</th>
                                <th>Keterangan</th>
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
        <!-- Add Modal -->
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addJadwalForm">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="kegiatan" class="form-label">Kegiatan</label>
                                    <input type="text" id="kegiatan" name="kegiatan" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="jam" class="form-label">Jam</label>
                                    <input type="time" id="jam" name="jam" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" id="lokasi" name="lokasi" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea id="keterangan" name="keterangan" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" novalidate>
                            <!-- Hidden input for ID -->
                            <input type="hidden" id="edit_id" name="edit_id" />

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="edit_tanggal" class="form-label">Tanggal</label>
                                    <input type="date" id="edit_tanggal" name="edit_tanggal" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="edit_kegiatan" class="form-label">Kegiatan</label>
                                    <input type="text" id="edit_kegiatan" name="edit_kegiatan" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="edit_jam" class="form-label">Jam</label>
                                    <input type="time" id="edit_jam" name="edit_jam" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="edit_lokasi" class="form-label">Lokasi</label>
                                    <input type="text" id="edit_lokasi" name="edit_lokasi" class="form-control" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="edit_keterangan" class="form-label">Keterangan</label>
                                    <textarea id="edit_keterangan" name="edit_keterangan" class="form-control" required></textarea>
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



        <script src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/vendor/libs/jquery/jquery.js"></script>
        <script src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/vendor/js/menu.js"></script>


        <script>
            $(document).ready(function() {
                // Tampilkan data awal
                tampil_data_ortu();

                // Fungsi untuk menampilkan data
                function tampil_data_ortu() {
                    $.ajax({
                        type: 'GET',
                        url: '<?= base_url('master/data_jadwal') ?>',
                        dataType: 'json',
                        success: function(data) {
                            var html = '';
                            for (var i = 0; i < data.length; i++) {
                                html += '<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' + data[i].tanggal + '</td>' +
                                    '<td>' + data[i].kegiatan + '</td>' +
                                    '<td>' + data[i].jam + '</td>' +
                                    '<td>' + data[i].lokasi + '</td>' +
                                    '<td>' + data[i].keterangan + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-warning btn-sm edit" data-id="' + data[i].id + '">Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm delete" data-id="' + data[i].id + '">Hapus</button>' +
                                    '</td>' +
                                    '</tr>';
                            }
                            $('#show_data').html(html);
                        },
                        error: function() {
                            alert('Gagal memuat data.');
                        }
                    });
                }

                // Tambah data
                $('#addJadwalForm').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('master/simpan_jadwal') ?>',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#basicModal').modal('hide');
                            tampil_data_ortu();
                            $('#addJadwalForm')[0].reset();
                        },
                        error: function() {
                            alert('Gagal menambahkan data.');
                        }
                    });
                });

                // Edit data
                $('#show_data').on('click', '.edit', function() {
                    var id = $(this).data('id');
                    $.ajax({
                        type: 'GET',
                        url: '<?= base_url('master/get_jadwal') ?>',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            $('#edit_id').val(data.id);
                            $('#edit_tanggal').val(data.tanggal);
                            $('#edit_kegiatan').val(data.kegiatan);
                            $('#edit_jam').val(data.jam);
                            $('#edit_lokasi').val(data.lokasi);
                            $('#edit_keterangan').val(data.keterangan);
                            $('#editModal').modal('show');
                        },
                        error: function() {
                            alert('Gagal memuat data untuk diedit.');
                        }
                    });
                });

                // Update data
                $('#editForm').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('master/update_jadwal') ?>',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#editModal').modal('hide');
                            tampil_data_ortu();
                        },
                        error: function() {
                            alert('Gagal mengupdate data.');
                        }
                    });
                });

                // Hapus data
                $('#show_data').on('click', '.delete', function() {
                    var id = $(this).data('id');
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url('master/hapus_jadwal') ?>',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                tampil_data_ortu();
                            },
                            error: function() {
                                alert('Gagal menghapus data.');
                            }
                        });
                    }
                });

                // Search data
                $('#searchInput').on('keyup', function() {
                    var query = $(this).val();
                    $.ajax({
                        type: 'GET',
                        url: '<?= base_url('master/search') ?>',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $('#show_data').html(response);
                        },
                        error: function() {
                            alert('Gagal mencari data.');
                        }
                    });
                });
            });
        </script>



    </div>
    </div>