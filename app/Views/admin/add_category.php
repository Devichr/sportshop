// Add Category View: app/Views/admin/add_category.php
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h2>Add Category</h2>
    <?= form_open('admin/categories/store') ?>
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    <?= form_close() ?>
<?= $this->endSection() ?>
