<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
        <h1 class="mt-5">Admin Dashboard</h1>
        <ul class="list-group my-4">
            <li class="list-group-item"><a href="<?php echo site_url('admin/products'); ?>">Manage Products</a></li>
            <!-- Tambahkan link lainnya untuk mengelola kategori, banner, dll. -->
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?= $this->endSection() ?>
