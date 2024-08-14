<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h2>Edit Product</h2>
    <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" name="name" class="form-control" id="name" value="<?= $product['name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" id="description" required><?= $product['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select name="category_id" class="form-control" id="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Product Image:</label>
            <input type="file" name="image" class="form-control-file" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>

<?= $this->endSection() ?>