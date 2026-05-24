<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <div class="card-body">

                <!-- Flash message for form errors or success -->
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= $this->session->flashdata('message'); ?>

                <!-- Tombol Tambah Menu dan Kolom Pencarian -->
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="demo-inline-spacing">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                <span class="menu-icon tf-icons bx bx-folder"></span>&nbsp; Tambah Menu
                            </button>
                            <br>
                        </div>
                    </div>
                </div>

                <!-- Tabel Menu -->
                <div class="table-responsive text-nowrap">
                    <table id="mydata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="show_data">
                            <?php $i = 1; ?>
                            <?php foreach ($menu as $m) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $m['menu']; ?></td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="<?= base_url('admin/editmenu/' . $m['id']); ?>" class="btn btn-warning btn-sm edit">Edit</a>
                                        <!-- Delete Button with Confirmation Modal -->
                                        <a href="<?= base_url('admin/deletemenu/' . $m['id']); ?>" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteMenuModal<?= $m['id']; ?>">Hapus</a>
                                    </td>
                                </tr>

                                <!-- Modal Konfirmasi Delete -->
                                <div class="modal fade" id="deleteMenuModal<?= $m['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus menu <strong><?= $m['menu']; ?></strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                <a href="<?= base_url('admin/deletemenu/' . $m['id']); ?>" class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Menu -->
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/menu'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="menu" name="menu" placeholder="Tulis Menu">
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