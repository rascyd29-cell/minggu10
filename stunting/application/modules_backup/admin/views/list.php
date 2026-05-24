<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class="bx bx-folder-open"></i>&nbsp; Tambah Akun
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
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="show_data"> <!-- Ubah di sini -->
                            <?php $no = 1;
                            foreach ($data as $u): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($u->name); ?></td>
                                    <td><?= htmlspecialchars($u->email); ?></td>
                                    <td><?= ($u->role_id == 1) ? "Admin" : (($u->role_id == 3) ? "Pengelola" : "Orang Tua"); ?></td>
                                    <td><?= ($u->is_active == 1) ? "Aktif" : "Tidak Aktif"; ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/edit/' . $u->id); ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $u->id; ?>)">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Akun -->
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?= form_open_multipart('admin/add', 'role="form" class="form-horizontal"'); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="2">Orang Tua</option>
                                <option value="3">Pengelola</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            </select>
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
                window.location = "<?= base_url('admin/hapus/'); ?>" + userId;
            }
        });
    }
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
</script>