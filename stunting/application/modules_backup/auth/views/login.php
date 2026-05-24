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
                    <h4 class="mb-2">Sistem Pendeteksi Dini Stunting</h4>

                    <?= $this->session->flashdata('message'); ?>

                    <form id="formAuthentication" class="mb-3" action="<?= base_url('auth'); ?>" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Masukkan Email Anda"
                                value="<?= set_value('email'); ?>"
                                autofocus />
                        </div>
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Ingat Saya </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>

                        </div>

                    </form>
                    <div class="text-center">
                        <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Lupa Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="<?= base_url('auth/registration'); ?>">Buat Akun!</a>
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>