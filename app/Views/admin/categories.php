<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h2>Categories</h2>
    <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary mb-3">Create Category</a>
    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category->name ?></td>
                    <td>
                        <a href="<?= base_url('admin/categories/edit/' . $category->id) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= base_url('admin/categories/delete/' . $category->id) ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?= $this->endSection() ?>