<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/custom/js_base.js'); ?>"></script>
<script src="<?= base_url('assets/sweetalert/sweetalert2.all.min.js'); ?>"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Handle SweetAlert2 for Flash Messages
    <?php if ($this->session->flashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $this->session->flashdata('success'); ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#198754'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= $this->session->flashdata('error'); ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('warning')): ?>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: '<?= $this->session->flashdata('warning'); ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ffc107'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('info')): ?>
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: '<?= $this->session->flashdata('info'); ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd'
        });
    <?php endif; ?>

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form.delete-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const message = form.dataset.deleteConfirm || 'Data yang terkait juga akan ikut terhapus. Yakin ingin melanjutkan?';

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        const dropdownToggles = document.querySelectorAll('.navbar .dropdown-toggle');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                const currentDropdown = this.closest('.dropdown');
                const currentMenu = currentDropdown.querySelector('.dropdown-menu');

                document.querySelectorAll('.navbar .dropdown-menu.show').forEach(menu => {
                    if (menu !== currentMenu) {
                        bootstrap.Dropdown.getInstance(menu.previousElementSibling)?.hide();
                    }
                });
            });
        });
    });
</script>

</body>
</html>
