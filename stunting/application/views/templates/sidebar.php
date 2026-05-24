<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?php echo base_url('auth') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?php echo base_url('assets/assets/ghulam/') ?>/assets/img/logo.png" style="max-height: 150px;" alt="Logo" />
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php
        $role_id = $this->session->userdata('role_id');
        $queryMenu = "SELECT `user_menu3`.`id`, `menu`
                            FROM `user_menu3` JOIN `user_access_menu3`
                              ON `user_menu3`.`id` = `user_access_menu3`.`menu_id`
                           WHERE `user_access_menu3`.`role_id` = $role_id
                        ORDER BY `user_access_menu3`.`menu_id` ASC
                        ";
        $menu = $this->db->query($queryMenu)->result_array();
        ?>

        <!-- LOOPING MENU -->
        <?php foreach ($menu as $m) : ?>
            <div class="menu-header small text-uppercase">
                <?= $m['menu']; ?>
            </div>

            <!-- SIAPKAN SUB-MENU SESUAI MENU -->
            <?php
            $menuId = $m['id'];
            $querySubMenu = "SELECT *
                               FROM `user_sub_menu3` JOIN `user_menu3` 
                                 ON `user_sub_menu3`.`menu_id` = `user_menu3`.`id`
                              WHERE `user_sub_menu3`.`menu_id` = $menuId
                                AND `user_sub_menu3`.`is_active` = 1
                        ";
            $subMenu = $this->db->query($querySubMenu)->result_array();
            ?>

            <?php foreach ($subMenu as $sm) : ?>
                <?php if ($title == $sm['title']) : ?>
                    <li class="menu-item active">
                    <?php else : ?>
                    <li class="menu-item">
                    <?php endif; ?>
                    <a class="menu-link" href="<?= base_url($sm['url']); ?>">
                        <i class="<?= $sm['icon']; ?>"></i>
                        <div data-i18n="Analytics"><?= $sm['title']; ?></div>
                    </a>
                    </li>
                <?php endforeach; ?>


            <?php endforeach; ?>

            <li class="menu-item">
                <a href="<?= base_url('auth/logout') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-log-out"></i>
                    <div data-i18n="Tables">Log Out</div>
                </a>
            </li>

</aside>
<!-- / Menu -->