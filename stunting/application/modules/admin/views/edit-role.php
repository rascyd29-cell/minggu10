<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header"><?= $title; ?></h5>
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-8">
                        <?= $this->session->flashdata('message'); ?>
                        <?= form_open('admin/editrole/' . $role['id']) ?>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Nama Role</label>
                            <div class="col-sm-10">
                                <input type="text" name="role" id="role" class="form-control" value="<?= $role['role']; ?>">
                                <?= form_error('role', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>

                        </form> <br>

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
    </div>
</div>
</div>
<!-- End of Main Content -->