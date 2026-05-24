<!-- Footer -->
<footer class="content-footer footer bg-footer-theme center">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-6 mb-md-0 text-center">
            © SHIELD
            <script>
                document.write(new Date().getFullYear());
            </script>, Dibuat Oleh Sistem Pendeteksi Dini Stunting ❤️
        </div>
    </div>
</footer>

<div class="content-backdrop fade"></div>
</div>
<div class="content-backdrop fade"></div>
</div>
<!-- Core JS -->
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/vendor/libs/popper/popper.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/vendor/js/bootstrap.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/vendor/js/menu.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/js/main.js"></script>
<script src="<?php echo base_url('assets/assets/ghulam/') ?>assets/js/dashboards-analytics.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });



    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });

    });
</script>

</body>

</html>