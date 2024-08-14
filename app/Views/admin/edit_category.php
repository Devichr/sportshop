<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h2>Edit Category</h2>
    <form action="<?= base_url('admin/categories/update/' . $category['id']) ?>" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name" value="<?= $category['name'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>

<?= $this->endSection() ?>