<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h2>Edit Banner</h2>
    <form action="<?= base_url('admin/banners/update/' . $banner['id']) ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" id="title" value="<?= $banner['title'] ?>" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Update Banner</button>
    </form>

<?= $this->endSection() ?>