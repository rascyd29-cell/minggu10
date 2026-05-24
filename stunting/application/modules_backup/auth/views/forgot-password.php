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
                    <h4 class="mb-2">Lupa Kata Sandi ?</h4>

                    <?= $this->session->flashdata('message'); ?>

                    <form id="formAuthentication" class="mb-3" action="<?= base_url('auth/forgotpassword'); ?>" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Masukkan Email Yang Akan direset Password"
                                value="<?= set_value('email'); ?>"
                                autofocus />
                        </div>
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>

                        </div>

                    </form>
                    <div class="text-center">
                        <a class="small" href="<?= base_url('auth'); ?>">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>