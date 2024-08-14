// Add Category View: app/Views/admin/add_category.php
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h2>Create Banner</h2>
    <form action="<?= base_url('admin/banners/store') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file" id="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Banner</button>
    </form>
<?= $this->endSection() ?>
