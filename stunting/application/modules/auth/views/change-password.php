<div class="container-xxl ">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="<?php echo base_url('auth') ?>" class="app-brand-link">
                            <span class="app-brand-logo demo">
                                <img src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/img/logo2.png" style="max-height: 40px;" alt="Logo" />
                            </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Ubah Password untuk</h4>
                    <h5 class="mb-4">
                        <center><?= $this->session->userdata('reset_email'); ?></center>
                    </h5>

                    <?= $this->session->flashdata('message'); ?>

                    <form id="formAuthentication" class="mb-3" action="<?= base_url('auth/changepassword'); ?>" method="POST">
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Tulis Password Baru</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password1"
                                    class="form-control"
                                    name="password1"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Ulangi Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password2"
                                    class="form-control"
                                    name="password2"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Ubah Password</button>

                        </div>
                    </form>

                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>