<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h2>Add Banner</h2>
    <?= form_open_multipart('admin/banners/store') ?>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Banner</button>
    <?= form_close() ?>
<?= $this->endSection() ?>