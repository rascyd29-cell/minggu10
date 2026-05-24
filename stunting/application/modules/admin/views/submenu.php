<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <div class="card-body">

                <!-- Flash message for form errors or success -->
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <?= $this->session->flashdata('message'); ?>

                <!-- Tombol Tambah Menu dan Kolom Pencarian -->
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="demo-inline-spacing">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                <span class="menu-icon tf-icons bx bx-folder-open"></span>&nbsp; Tambah Sub Menu
                            </button>
                            <br>
                        </div>
                    </div>
                </div>
                <br>

                <!-- Tabel Menu -->
                <div class="table-responsive text-nowrap">
                    <table id="mydata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Menu</th>
                                <th>Url</th>
                                <th>Ikon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="show_data">
                            <?php $i = 1; ?>
                            <?php foreach ($subMenu as $sm) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $sm['title']; ?></td>
                                    <td><?= $sm['menu']; ?></td>
                                    <td><?= $sm['url']; ?></td>
                                    <td><?= $sm['icon']; ?></td>
                                    <td><?= $sm['is_active']; ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/editsub/' . $sm['id']) ?>" class="btn btn-warning btn-sm edit">Edit</a>
                                        <a href="<?= base_url('admin/deletesub/' . $sm['id']) ?>" class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#deleteSubmenu">Hapus</a>
                                    </td>
                                </tr>
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
                        <h5 class="modal-title">Tambah Sub Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/submenu'); ?>" method="post">
                        <div class="modal-body">
                            <label class="control-label col-xs-3">Judu Sub Menu</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
                            </div><br>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Pilih Menu</label>
                                <select name="menu_id" id="menu_id" class="form-control">
                                    <option value="">Pilih Menu</option>
                                    <?php foreach ($menu as $m) : ?>
                                        <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Url</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                            </div><br>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Ikon</label>
                                <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
                            </div><br>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Status</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div><br>
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