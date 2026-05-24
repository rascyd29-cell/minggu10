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


        <script type="text/javascript">
            $(document).ready(function() {
                tampil_data_ortu();

                function tampil_data_ortu() {
                    $.ajax({
                        type: 'ajax',
                        url: '<?= base_url('master/data_jadwal') ?>',
                        async: false,
                        dataType: 'json',
                        success: function(data) {
                            var html = '';
                            var i;
                            for (i = 0; i < data.length; i++) {
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
                        }
                    });
                }



                // Add new parent
                $('#addJadwalForm').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('master/simpan_jadwal') ?>',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#basicModal').modal('hide');
                                tampil_data_ortu(); // Reload the data
                                $('#addJadwalForm')[0].reset(); // Reset form
                            } else {
                                $('#message').html('<div class="alert alert-danger">Gagal menambahkan data.</div>');
                            }
                        }
                    });
                });


                // Edit parent
                // Event listener untuk tombol edit
                $('#show_data').on('click', '.edit', function() {
                    var id = $(this).data('id'); // Ambil ID dari tombol edit yang di-klik

                    // Ajax request untuk mengambil data dari server berdasarkan ID
                    $.ajax({
                        type: 'GET',
                        url: '<?= base_url('master/get_jadwal') ?>', // Sesuaikan URL dengan endpoint
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                // Jika data berhasil diambil, isi form di modal dengan data yang diambil
                                $('#edit_id').val(data.id);
                                $('#edit_tanggal').val(data.tanggal);
                                $('#edit_kegiatan').val(data.kegiatan);
                                $('#edit_jam').val(data.jam);
                                $('#edit_lokasi').val(data.lokasi);
                                $('#edit_keterangan').val(data.keterangan);

                                // Tampilkan modal edit
                                $('#editModal').modal('show');
                            } else {
                                // Jika tidak ada data yang ditemukan, tampilkan pesan error (opsional)
                                $('#edit_message').html('<div class="alert alert-danger">Data tidak ditemukan.</div>');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Tampilkan pesan error jika terjadi masalah pada request
                            $('#edit_message').html('<div class="alert alert-danger">Terjadi kesalahan saat mengambil data.</div>');
                        }
                    });
                });


                // Update parent
                $('#editForm').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('master/update_jadwal') ?>',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#editModal').modal('hide');
                                tampil_data_ortu();
                            } else {
                                $('#edit_message').html('<div class="alert alert-danger">Gagal mengupdate data.</div>');
                            }
                        }
                    });
                });

                // Delete parent
                $('#show_data').on('click', '.delete', function() {
                    var id = $(this).data('id');
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url('master/hapus_jadwal') ?>',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    tampil_data_ortu();
                                } else {
                                    alert('Gagal menghapus data.');
                                }
                            }
                        });
                    }
                });


                // Cleanup when modal is hidden
                $('#basicModal').on('hidden.bs.modal', function() {
                    // Optionally, reset any messages or forms
                    $('#message').html('');

                    // Remove the modal backdrop if it persists (though it usually shouldn't)
                    $('.modal-backdrop').remove();
                });
            });
        </script>
        <script>
            function searchData() {
                var searchQuery = $('#searchInput').val(); // Get the search input value

                $.ajax({
                    url: '<?= base_url('master/search') ?>', // URL to the search method
                    type: 'GET',
                    data: {
                        query: searchQuery // Send the search query
                    },
                    success: function(response) {
                        $('#show_data').html(response); // Update the main table body with search results
                    },
                    error: function() {
                        $('#show_data').html('<tr><td colspan="4">Error retrieving data.</td></tr>'); // Handle errors
                    }
                });
            }

            // Optional: Trigger search on Enter key press
            $('#searchInput').on('keypress', function(event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    searchData(); // Trigger the search
                }
            });
        </script>


    </div>
    </div>