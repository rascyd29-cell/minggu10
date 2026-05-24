<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <div class="card-body">
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= $this->session->flashdata('message'); ?>

                <!-- Tombol Tambah Role dan Kolom Pencarian -->
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="demo-inline-spacing">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                <span class="menu-icon tf-icons bx bx-user"></span>&nbsp; Tambah Role
                            </button> <br>
                        </div>
                    </div>
                </div>

                <!-- Tabel Role -->
                <div class="table-responsive text-nowrap">
                    <table id="mydata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="show_data">
                            <?php
                            $i = 1;
                            foreach ($role as $r) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $r['role'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="btn btn-secondary btn-sm">Akses</a>
                                        <a href="<?= base_url('admin/editrole/') . $r['id']; ?>" class="btn btn-warning btn-sm edit" data-id="<?= $r['id']; ?>">Edit</a>
                                        <a href="<?= base_url('admin/deleterole/') . $r['id']; ?>" class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#deleteRole">Hapus</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Role -->
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/role'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="role" name="role" placeholder="Role Name">
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

        <!-- Modal Edit Role -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editForm">
                        <input type="hidden" id="edit_id" name="edit_id" />
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="edit_role" name="edit_role" placeholder="Role Name">
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

</div>
</div>
<!-- End of Main Content -->