<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <div class="card-body">
                <!-- Bagian ini diubah agar Last Update dan tombol Reset ada di sebelah kanan -->
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <?php foreach ($data2_ as $u) : ?>
                        <h7 class="mr-3">Update : <?= $u->time ?></h7> <!-- Last Update -->
                    <?php endforeach; ?>
                </div>
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <a href="#" id="resetButton" class="btn btn-danger">Reset Data</a>
                </div>

                <!-- Form Error dan Flash Message -->
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= $this->session->flashdata('message'); ?>

                <h5 class="card-header">
                    <center>Topi</center>
                </h5>
                <!-- Tabel Data untuk Topi -->
                <div class="table-responsive">
                    <table id="datatable_topi" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Tinggi (cm)</th>
                                <th>Lingkar Kepala (cm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($data_ as $u) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $u->time ?></td>
                                    <td><?= $u->height ?></td>
                                    <td><?= $u->head ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <h5 class="card-header">
                    <center>Timbangan</center>
                </h5>
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <?php foreach ($data2 as $u) : ?>
                        <h7 class="mr-3">Update : <?= $u->time ?></h7> <!-- Last Update -->
                    <?php endforeach; ?>
                </div>
                <!-- Tabel Data untuk Timbangan -->
                <div class="table-responsive">
                    <table id="datatable_timbangan" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Berat Badan (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($data as $u) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $u->time ?></td>
                                    <td><?= $u->mass ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>

<!-- Modal Pop-up untuk Reset Data -->
<div class="modal fade" id="confirmResetModal" tabindex="-1" role="dialog" aria-labelledby="confirmResetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmResetModalLabel">Konfirmasi Reset Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin akan mengosongkan data history sensor?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="<?= base_url('data/reset_data'); ?>" id="confirmResetButton" class="btn btn-danger">Ya, Reset Data</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Inisialisasi DataTables untuk tabel Topi
        $('#datatable_topi').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'csv'
            ]
        });

        // Inisialisasi DataTables untuk tabel Timbangan
        $('#datatable_timbangan').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'csv'
            ]
        });

        // Tambahkan event listener untuk tombol Reset Data
        $('#resetButton').on('click', function(e) {
            e.preventDefault(); // Batalkan aksi default
            $('#confirmResetModal').modal('show'); // Tampilkan modal konfirmasi
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Event listener untuk tombol Reset Data
        $('#resetButton').on('click', function(e) {
            e.preventDefault(); // Batalkan aksi default dari link
            $('#confirmResetModal').modal('show'); // Tampilkan modal konfirmasi
        });

        // Event listener untuk tombol Batal atau Close
        $('.btn-secondary, .close').on('click', function() {
            $('#confirmResetModal').modal('hide'); // Tutup modal
        });

        // Event listener untuk tombol Konfirmasi Reset
        $('#confirmResetButton').on('click', function() {
            // Redirect ke URL reset data
            window.location.href = '<?= base_url('data/reset_data'); ?>';
        });
    });
</script>